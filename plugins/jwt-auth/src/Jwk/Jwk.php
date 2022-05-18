<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Jwk;

use Firebase\JWT\JWT;

/**
 * An implementation of the JWK RFC
 *
 * @link https://datatracker.ietf.org/doc/html/rfc7517#section-4
 */
class Jwk implements JwkInterface
{
    /**
     * @param string $kty Key type parameter (e.g. RSA, EC)
     * @param string|null $use Public key use (sig or enc)
     * @param string|null $alg Algorithm
     * @param string|null $kid Key ID
     * @param array $parameters Key-value array of additional JWK parameters
     * @link https://datatracker.ietf.org/doc/html/rfc7517#section-4
     */
    public function __construct(
        private string $kty,
        private ?string $use = null,
        private ?string $alg = null,
        private ?string $kid = null,
        private array $parameters = [],
    ) {
    }

    /**
     * Creates an instance.
     *
     * @param string $kty Key type
     * @param string $alg Algorithm
     * @param string $pubKey The full text of the public key.
     * @param string $kid Key ID.
     * @return self
     */
    public static function create(string $kty, string $alg, string $pubKey, string $kid): Jwk
    {
        $res = openssl_pkey_get_public($pubKey);
        $detail = openssl_pkey_get_details($res);

        return new Jwk(
            $kty,
            'sig',
            $alg,
            $kid,
            [
                'n' => JWT::urlsafeB64Encode($detail['rsa']['n']),
                'e' => JWT::urlsafeB64Encode($detail['rsa']['e']),
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function getKty(): string
    {
        return $this->kty;
    }

    /**
     * @inheritDoc
     */
    public function getUse(): ?string
    {
        return $this->use;
    }

    /**
     * @inheritDoc
     */
    public function getAlg(): ?string
    {
        return $this->alg;
    }

    /**
     * @inheritDoc
     */
    public function getKid(): ?string
    {
        return $this->kid;
    }

    /**
     * @inheritDoc
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = get_object_vars($this);
        unset($array['parameters']);

        foreach ($this->getParameters() as $k => $v) {
            $array[$k] = $v;
        }

        return $array;
    }
}
