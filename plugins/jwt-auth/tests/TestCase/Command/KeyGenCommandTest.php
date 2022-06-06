<?php

namespace MixerApi\JwtAuth\Test\TestCase\Command;

use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Monolog\Test\TestCase;

class KeyGenCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    public function setUp() : void
    {
        parent::setUp();
        $this->useCommandRunner();
    }

    public function test_hmac(): void
    {
        $this->exec('mixerapi:jwtauth keygen hmac');
        $this->assertOutputContains('Generating base64 encoded hash:');
        $this->assertEquals(44, strlen($this->_out->messages()[1]));
    }

    public function test_rsa(): void
    {
        $this->exec('mixerapi:jwtauth keygen rsa');
        $this->assertOutputContains('Generating RSA keypair:');
        $this->assertOutputContains('-----BEGIN PRIVATE KEY-----');
        $this->assertOutputContains('-----END PRIVATE KEY-----');
        $this->assertOutputContains('-----BEGIN PUBLIC KEY-----');
        $this->assertOutputContains('-----END PUBLIC KEY-----');
    }
}
