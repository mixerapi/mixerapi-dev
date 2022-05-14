<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Jwk;

/**
 * An implementation of the JWK RFC
 *
 * @link https://datatracker.ietf.org/doc/html/rfc7517#section-4
 */
interface JwkInterface
{
    /**
     * @see Jwk::getKty()
     * @return string
     */
    public function getKty(): string;

    /**
     * @see Jwk::getUse()
     * @return string|null
     */
    public function getUse(): ?string;

    /**
     * @see Jwk::getAlg()
     * @return string|null
     */
    public function getAlg(): ?string;

    /**
     * @see Jwk::getKid()
     * @return string|null
     */
    public function getKid(): ?string;

    /**
     * @see Jwk::getParameters()
     * @return array
     */
    public function getParameters(): array;
}
