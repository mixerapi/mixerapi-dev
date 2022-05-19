<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Jwk;

/**
 * @see \MixerApi\JwtAuth\Jwk\JwkSet
 */
interface JwkSetInterface
{
    /**
     * Returns a JWK Set as an array of arrays. Example:
     *
     * ```
     * return ['keys' => [[...]]];
     * ```
     *
     * @link https://datatracker.ietf.org/doc/html/rfc7517
     * @see \MixerApi\JwtAuth\Jwk\JwkSet::getKeySet()
     * @return array
     */
    public function getKeySet(): array;

    /**
     * Returns the first item in the keyset.
     *
     * @see \MixerApi\JwtAuth\Jwk\JwkSet::getFirst()
     * @return array
     */
    public function getFirst(): array;
}
