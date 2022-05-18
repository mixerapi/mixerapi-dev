<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth;

use Authentication\Controller\Component\AuthenticationComponent;
use MixerApi\JwtAuth\Jwt\JwtInterface;

interface JwtAuthenticatorInterface
{
    /**
     * Authenticates the user and returns a JSON Web Token.
     *
     * @see JwtAuthenticator::authenticate()
     * @param \Authentication\Controller\Component\AuthenticationComponent|\MixerApi\JwtAuth\Jwt\JwtInterface $arg JwtInterface or an instance of
     * AuthenticationComponent which can be used to retrieve the Jwt from the Result.
     * @return string
     * @throws \MixerApi\JwtAuth\Exception\JwtAuthException
     */
    public function authenticate(AuthenticationComponent|JwtInterface $arg): string;
}
