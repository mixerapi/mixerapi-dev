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
}
