<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Test\Jwk;

use Cake\TestSuite\TestCase;
use MixerApi\JwtAuth\Configuration\Configuration;
use MixerApi\JwtAuth\Jwk\JwkSet;
use MixerApi\JwtAuth\Test\TestHelper;

class JwkSetTest extends TestCase
{
    public function test_getKeySet(): void
    {
        TestHelper::createRs256Config();
        $keySet = (new JwkSet)->getKeySet();
        $this->assertCount(3, $keySet['keys']);
    }

    public function test_getFirst(): void
    {
        TestHelper::createRs256Config();
        $this->assertNotNull((new JwkSet(new Configuration))->getFirst());
    }
}
