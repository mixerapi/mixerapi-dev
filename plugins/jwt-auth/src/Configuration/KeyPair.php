<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Configuration;

class KeyPair
{
    /**
     * @todo convert to read-only properties in PHP 8.1
     * @param string $kid Key ID
     * @param string $public Public key
     * @param string $private Private Key
     */
    public function __construct(
        public string $kid,
        public string $public,
        public string $private
    ) {
    }
}
