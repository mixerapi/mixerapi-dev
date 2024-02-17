<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Test\TestCase\Jwk;

use Cake\TestSuite\TestCase;
use MixerApi\JwtAuth\Configuration\Configuration;
use MixerApi\JwtAuth\Exception\JwtAuthException;
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

    public function test_getKeySet_throws_exception_when_alg_invalid(): void
    {
        $this->expectException(JwtAuthException::class);
        TestHelper::createHs256Config();
        (new JwkSet)->getKeySet();
    }
}
