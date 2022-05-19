<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Configuration;

use Cake\Core\Configure;
use MixerApi\JwtAuth\Exception\JwtAuthException;

class Configuration
{
    /**
     * Allowed algorithms
     *
     * @var string[]
     */
    public const ALG = ['RS256', 'RS512', 'HS256', 'HS512'];

    /**
     * @var int Required size of HMAC secret
     */
    private const SECRET_LENGTH = 32;

    /**
     * @var int Required RSA key size
     */
    private const RSA_KEY_LENGTH = 2048;

    /**
     * Signing algorithm
     *
     * @see Configuration::ALG
     * @var string
     */
    private string $alg;

    /**
     * Required for HS256.
     *
     * @var string|null
     */
    private ?string $secret = null;

    /**
     * @var \MixerApi\JwtAuth\Configuration\KeyPair[]
     */
    private array $keyPairs = [];

    /**
     * @param \Cake\Core\Configure|null $configure Cake Configure instance
     * @throws \MixerApi\JwtAuth\Exception\JwtAuthException
     */
    public function __construct(?Configure $configure = null)
    {
        $config = ($configure ?? new Configure())::read('MixerApi.JwtAuth');
        if ($config === null) {
            throw new JwtAuthException(
                'Invalid configuration. Could not read MixerApi.JwtAuth config.'
            );
        }

        $this->alg = strtoupper((string)$config['alg']);
        if (!in_array($this->alg, self::ALG)) {
            throw new JwtAuthException(
                "Invalid configuration. Alg `$this->alg` is either invalid, unsupported or unknown. " .
                'The value of `MixerApi.JwtAuth.alg` must be one of: ' . implode(', ', self::ALG)
            );
        }

        if (str_starts_with(haystack: $this->alg, needle: 'HS')) {
            if (empty($config['secret']) || !is_string($config['secret'])) {
                throw new JwtAuthException(
                    'Invalid configuration. `MixerApi.JwtAuth.secret` is a required string when using HMAC.'
                );
            }
            if (strlen($config['secret']) < self::SECRET_LENGTH) {
                throw new JwtAuthException(
                    sprintf(
                        'HMAC secret must be >= %s characters, but yours is %s ' .
                        ' characters. Increase the length of your MixerApi.JwtAuth.secret',
                        self::SECRET_LENGTH,
                        strlen($config['secret'])
                    )
                );
            }
            $this->secret = $config['secret'];
        } elseif (str_starts_with(haystack: $this->alg, needle: 'RS')) {
            if (empty($config['keys']) || !is_array($config['keys'])) {
                throw new JwtAuthException(
                    'Invalid configuration. `MixerApi.JwtAuth.keys` must contain keys when using RSA.'
                );
            }

            foreach ($config['keys'] as $key) {
                $keyPair = new KeyPair(...$key);
                $res = openssl_pkey_get_public($keyPair->public);
                $detail = openssl_pkey_get_details($res);

                if ($detail['bits'] < self::RSA_KEY_LENGTH) {
                    throw new JwtAuthException(
                        sprintf(
                            'Invalid configuration. RSA keys must be at least %s bits, but yours is %s. ' .
                            'Please generate stronger keys.',
                            self::RSA_KEY_LENGTH,
                            $detail['bits']
                        )
                    );
                }

                $this->keyPairs[] = $keyPair;
            }
        }
    }

    /**
     * @return string
     */
    public function getAlg(): string
    {
        return $this->alg;
    }

    /**
     * @return string|null
     */
    public function getSecret(): ?string
    {
        return $this->secret;
    }

    /**
     * @return \MixerApi\JwtAuth\Configuration\KeyPair[]
     */
    public function getKeyPairs(): array
    {
        return $this->keyPairs;
    }

    /**
     * Return a specific key
     *
     * @param string $kid The kid to search for.
     * @return \MixerApi\JwtAuth\Configuration\KeyPair|null
     * @throws \MixerApi\JwtAuth\Exception\JwtAuthException
     */
    public function getKeyPairByKid(string $kid): ?KeyPair
    {
        $keys = $this->getKeyPairs();
        foreach ($keys as $key) {
            if ($key->kid === $kid) {
                return $key;
            }
        }

        return null;
    }
}
