<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Test\Configuration;

use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;
use MixerApi\JwtAuth\Configuration\Configuration;
use MixerApi\JwtAuth\Exception\JwtAuthException;
use MixerApi\JwtAuth\Test\TestHelper;

class ConfigurationTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Configure::delete('MixerApi.JwtAuth');
    }

    public function test_construct_should_throw_exception_when_config_is_missing(): void
    {
        $this->expectException(JwtAuthException::class);
        new Configuration;
    }

    public function test_construct_should_throw_exception_when_alg_is_invalid(): void
    {
        $this->expectException(JwtAuthException::class);
        Configure::write('MixerApi.JwtAuth', [
            'alg' => 'NOPE',
        ]);
        new Configuration;
    }

    public function test_construct_should_throw_exception_when_secret_is_invalid(): void
    {
        $this->expectException(JwtAuthException::class);
        Configure::write('MixerApi.JwtAuth', [
            'alg' => 'HS256',
        ]);
        new Configuration;

        foreach ([null, ''] as $secret) {
            $this->expectException(JwtAuthException::class);
            Configure::write('MixerApi.JwtAuth', [
                'alg' => 'HS256',
                'secret' => $secret,
            ]);
            new Configuration;
        }
    }

    public function test_getAlg(): void
    {
        TestHelper::createHs256Config();
        $this->assertEquals('HS256', (new Configuration)->getAlg());

        TestHelper::createRs256Config();
        $this->assertEquals('RS256', (new Configuration)->getAlg());
    }

    public function test_getSecret(): void
    {
        TestHelper::createHs256Config();
        $this->assertEquals(Security::getSalt(), (new Configuration)->getSecret());

        TestHelper::createRs256Config();
        $this->assertNull((new Configuration)->getSecret());
    }

    public function test_getKeyPairs(): void
    {
        Configure::write('MixerApi.JwtAuth', [
            'alg' => 'RS256',
            'keys' => [
                ['kid' => 'abc1', 'public' => 'pub', 'private' => 'pri'],
                ['kid' => 'abc2', 'public' => 'pub', 'private' => 'pri'],
                ['kid' => 'abc3', 'public' => 'pub', 'private' => 'pri'],
            ],
        ]);
        $this->assertCount(3, (new Configuration)->getKeyPairs());
    }

    public function test_getKeyPairs_throws_exception_when_config_is_invalid(): void
    {
        $this->expectException(JwtAuthException::class);
        Configure::write('MixerApi.JwtAuth', [
            'alg' => 'RS256',
        ]);
        (new Configuration)->getKeyPairs();
    }

    public function test_getKeyPairByKid(): void
    {
        Configure::write('MixerApi.JwtAuth', [
            'alg' => 'RS256',
            'keys' => [
                ['kid' => 'abc1', 'public' => 'pub', 'private' => 'pri'],
                ['kid' => 'abc2', 'public' => 'pub', 'private' => 'pri'],
                ['kid' => 'abc3', 'public' => 'pub', 'private' => 'pri'],
            ],
        ]);
        $this->assertNotNull((new Configuration)->getKeyPairByKid('abc2'));
        $this->assertNull((new Configuration)->getKeyPairByKid('nope'));
    }
}
