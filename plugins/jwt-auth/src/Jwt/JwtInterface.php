<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Jwt;

/**
 * @link https://datatracker.ietf.org/doc/html/rfc7519
 */
interface JwtInterface
{
    /**
     * Issuer of the token (e.g. your organization). This is optional, if null the property will be omitted.
     *
     * @return string|null
     * @link https://datatracker.ietf.org/doc/html/rfc7519#section-4.1.1
     * @see \MixerApi\JwtAuth\Jwt\Jwt
     */
    public function getIss(): ?string;

    /**
     * Subject of this claim. This is typically a unique identifier (e.g. user id). This is optional, if null the
     * property will be omitted.
     *
     * @return string
     * @link https://datatracker.ietf.org/doc/html/rfc7519#section-4.1.2
     * @see \MixerApi\JwtAuth\Jwt\Jwt::getSub()
     */
    public function getSub(): string;

    /**
     * Audience this token is intended for This is optional, if null the property will be omitted.
     * Otherwise, a single string or an array of strings should be used.
     *
     * @return string|array|null
     * @link https://datatracker.ietf.org/doc/html/rfc7519#section-4.1.3
     * @see \MixerApi\JwtAuth\Jwt\Jwt::getAud()
     */
    public function getAud(): mixed;

    /**
     * Expiration time specifies at what time the token will expire expressed as a unix timestamp.
     *
     * @return int
     * @link https://datatracker.ietf.org/doc/html/rfc7519#section-4.1.4
     * @see \MixerApi\JwtAuth\Jwt\Jwt::getExp()
     */
    public function getExp(): int;

    /**
     * Not Before time specifies at time before the token can be used. This is optional, if null the property will be
     * omitted.
     *
     * @return int|null
     * @link https://datatracker.ietf.org/doc/html/rfc7519#section-4.1.5
     * @see \MixerApi\JwtAuth\Jwt\Jwt::getNbf()
     */
    public function getNbf(): ?int;

    /**
     * Issued at time specifies when the token was issued expressed as a unix timestamp. This is optional, if null
     * the property will be omitted.
     *
     * @return int|null
     * @link https://datatracker.ietf.org/doc/html/rfc7519#section-4.1.6
     * @see \MixerApi\JwtAuth\Jwt\Jwt::getIat()
     */
    public function getIat(): ?int;

    /**
     * JWT ID is a unique identifier for the token. This is optional, if null the property will be omitted.
     *
     * @return string|null
     * @link https://datatracker.ietf.org/doc/html/rfc7519#section-4.1.7
     * @see \MixerApi\JwtAuth\Jwt\Jwt::getJti()
     */
    public function getJti(): ?string;

    /**
     * A key-value list of additional information to include in the JWT such as user metadata etc. If null, no
     * claims will be added.
     *
     * @return array|null
     * @link https://datatracker.ietf.org/doc/html/rfc7519#section-4.3
     * @see \MixerApi\JwtAuth\Jwt\Jwt::getPrivateClaims()
     */
    public function getClaims(): ?array;
}
