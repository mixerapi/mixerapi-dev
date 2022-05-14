<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Jwk;

use MixerApi\JwtAuth\Configuration\Configuration;

/**
 * An implementation of the JWK RFC
 *
 * @link https://datatracker.ietf.org/doc/html/rfc7517#section-4
 */
class JwkSet implements JwkSetInterface
{
    /**
     * @param \MixerApi\JwtAuth\Configuration\Configuration|null $config Configuration
     */
    public function __construct(private ?Configuration $config = null)
    {
        $this->config = $this->config ?? new Configuration();
    }

    /**
     * @inheritDoc
     */
    public function getKeySet(): array
    {
        $keyPairs = $this->config->getKeyPairs();

        $keys = [];
        foreach ($keyPairs as $keyPair) {
            $keys[] = Jwk::create('RSA', $this->config->getAlg(), $keyPair->public, $keyPair->kid)->toArray();
        }

        return ['keys' => $keys];
    }

    /**
     * @inheritDoc
     */
    public function getFirst(): array
    {
        return reset($this->getKeySet()['keys']);
    }
}
