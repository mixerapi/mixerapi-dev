<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth;

use Authentication\Authenticator\UnauthenticatedException;
use Authentication\Controller\Component\AuthenticationComponent;
use Firebase\JWT\JWT as FirebaseJwt;
use MixerApi\JwtAuth\Configuration\Configuration;
use MixerApi\JwtAuth\Exception\JwtAuthException;
use MixerApi\JwtAuth\Jwt\JwtEntityInterface;
use MixerApi\JwtAuth\Jwt\JwtInterface;

class JwtAuthenticator implements JwtAuthenticatorInterface
{
    /**
     * @param \MixerApi\JwtAuth\Configuration\Configuration $config JwtAuth Configuration
     */
    public function __construct(private Configuration $config)
    {
    }

    /**
     * @inheritDoc
     */
    public function authenticate(AuthenticationComponent|JwtInterface $arg): string
    {
        $jwt = $this->getJwt($arg);
        $payload = $this->getPayload($jwt);

        return match (substr($this->config->getAlg(), 0, 2)) {
            'HS' => FirebaseJwt::encode($payload, $this->config->getSecret(), $this->config->getAlg()),
            'RS' => $this->rsa($payload),
            default => throw new JwtAuthException("Unknown alg: {$this->config->getAlg()}")
        };
    }

    /**
     * @param array $payload The JWT after being converted to an array
     * @return string
     * @throws \MixerApi\JwtAuth\Exception\JwtAuthException
     */
    private function rsa(array $payload): string
    {
        $keyPairs = $this->config->getKeyPairs();
        $keyPair = reset($keyPairs);

        return FirebaseJwt::encode($payload, $keyPair->private, $this->config->getAlg(), $keyPair->kid);
    }

    /**
     * Get the JWT from the argument.
     *
     * @param \Authentication\Controller\Component\AuthenticationComponent|\MixerApi\JwtAuth\Jwt\JwtInterface $arg An
     *  instance of Cake's AuthenticationComponent or JwtInterface
     * @return \MixerApi\JwtAuth\Jwt\JwtInterface
     * @throws \MixerApi\JwtAuth\Exception\JwtAuthException
     */
    private function getJwt(AuthenticationComponent|JwtInterface $arg): JwtInterface
    {
        if ($arg instanceof JwtInterface) {
            return $arg;
        }

        $result = $arg->getResult();
        if (!$result->isValid()) {
            if (count($result->getErrors())) {
                throw new UnauthenticatedException(implode('. ', $result->getErrors()));
            }
            throw new UnauthenticatedException($result->getStatus());
        }

        $data = $result->getData();
        if (!$data instanceof JwtEntityInterface) {
            throw new JwtAuthException(
                sprintf(
                    'ResultInterface::getData must return an instance of %s',
                    JwtEntityInterface::class
                )
            );
        }

        return $data->getJwt();
    }

    /**
     * @param \MixerApi\JwtAuth\Jwt\JwtInterface $jwt JwtInterface
     * @return array
     */
    private function getPayload(JwtInterface $jwt): array
    {
        $payload = [
            'iss' => $jwt->getIss(),
            'sub' => $jwt->getSub(),
            'aud' => $jwt->getAud(),
            'exp' => $jwt->getExp(),
            'nbf' => $jwt->getNbf(),
            'iat' => $jwt->getIat(),
            'jti' => $jwt->getJti(),
        ];

        $claims = $jwt->getClaims();
        if (is_array($claims)) {
            $payload = array_merge($payload, $claims);
        }

        foreach ($payload as $k => $v) {
            if (is_null($v)) {
                unset($payload[$k]);
            }
        }

        return $payload;
    }
}
