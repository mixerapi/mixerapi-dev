<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Test\TestCase\Jwk;

use Cake\TestSuite\TestCase;
use MixerApi\JwtAuth\Jwk\Jwk;

class JwkTest extends TestCase
{
    public function test(): void
    {
        $jwk = new Jwk('RSA', 'sig', 'RS256', '1');
        $this->assertEquals('RSA', $jwk->getKty());
        $this->assertEquals('sig', $jwk->getUse());
        $this->assertEquals('RS256', $jwk->getAlg());
        $this->assertEquals('1', $jwk->getKid());
        $this->assertIsArray($jwk->getParameters());
    }
}
