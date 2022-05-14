<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Jwt;

interface JwtEntityInterface
{
    /**
     * Returns a JWT token.
     *
     * @return \MixerApi\JwtAuth\Jwt\JwtInterface
     */
    public function getJwt(): JwtInterface;
}
