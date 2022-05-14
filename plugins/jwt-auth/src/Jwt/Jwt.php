<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Jwt;

class Jwt implements JwtInterface
{
    /**
     * For detailed descriptions of JWT properties read the RFC.
     *
     * @link https://datatracker.ietf.org/doc/html/rfc7519
     * @param int $exp Expiration time claim
     * @param string $sub Subject claim
     * @param string|null $iss The issuer
     * @param array|string|null $aud Audience claim
     * @param int|null $nbf Not before time claim
     * @param int|null $iat Issued at time claim
     * @param string|null $jti JWT identifier claim
     * @param array $claims Additional claims
     */
    public function __construct(
        private int $exp,
        private string $sub,
        private ?string $iss = null,
        private mixed $aud = null,
        private ?int $nbf = null,
        private ?int $iat = null,
        private ?string $jti = null,
        private array $claims = []
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getIss(): ?string
    {
        return $this->iss;
    }

    /**
     * @inheritDoc
     */
    public function getSub(): string
    {
        return $this->sub;
    }

    /**
     * @inheritDoc
     */
    public function getAud(): mixed
    {
        return $this->aud;
    }

    /**
     * @inheritDoc
     */
    public function getExp(): int
    {
        return $this->exp;
    }

    /**
     * @inheritDoc
     */
    public function getNbf(): ?int
    {
        return $this->nbf;
    }

    /**
     * @inheritDoc
     */
    public function getIat(): ?int
    {
        return $this->iat;
    }

    /**
     * @inheritDoc
     */
    public function getJti(): ?string
    {
        return $this->jti;
    }

    /**
     * @inheritDoc
     */
    public function getClaims(): ?array
    {
        return $this->claims;
    }
}
