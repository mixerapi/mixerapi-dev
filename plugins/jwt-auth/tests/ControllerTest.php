<?php

namespace MixerApi\JwtAuth\Test;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\JWK as FirebaseJWK;
use MixerApi\JwtAuth\Configuration\Configuration;
use MixerApi\JwtAuth\Exception\JwtAuthException;
use MixerApi\JwtAuth\Jwk\JwkSet;

class ControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @var string[]
     */
    public $fixtures = [
        'plugin.MixerApi/JwtAuth.Users',
    ];

    public function setUp(): void
    {
        parent::setUp();
        static::setAppNamespace('MixerApi\JwtAuth\Test\App');
    }

    /**
     * When requesting the JWKS endpoint, the server responds with the keyset.
     */
    public function test_jwks(): void
    {
        TestHelper::createRs256Config();
        $this->get('/test/jwks.json');
        $this->assertResponseOk();
        $body = (string)$this->_response->getBody();
        $result = json_decode($body);
        $this->assertcount(3, $result->keys);
    }

    /**
     * When a valid login request is made with the given algorithm, the server responds with a JWT.
     *
     * @dataProvider dataProviderForAlg
     * @param string $alg
     * @return void
     * @throws JwtAuthException
     */
    public function test_login(string $alg): void
    {
        $alg === 'RS' ? TestHelper::createRs256Config() : TestHelper::createHs256Config();
        $this->post('/test/login.json', ['email' => 'test@example.com', 'password' => 'password']);
        $this->assertResponseCode(200);
        $body = (string)$this->_response->getBody();

        if ($alg === 'RS') {
            $jwt = Jwt::decode($body, FirebaseJWK::parseKeySet((new JwkSet())->getKeySet()), ['RS256']);
        } else {
            $jwt = Jwt::decode($body, new Key((new Configuration)->getSecret(), 'HS256'));
        }

        $this->assertEquals('mixerapi', $jwt->iss);
        $this->assertEquals('test@example.com', $jwt->user->email);
    }

    /**
     * When a login request is made with invalid credentials for the given algorithm the server responds with a 401.
     *
     * @dataProvider dataProviderForAlg
     * @param string $alg
     * @return void
     */
    public function test_login_fails(string $alg): void
    {
        $alg === 'RS' ? TestHelper::createRs256Config() : TestHelper::createHs256Config();
        $this->post('/test/login.json', ['email' => 'test@example.com', 'password' => 'nope']);
        $this->assertResponseCode(401);
    }

    /**
     * When an authenticated request is made to an endpoint requiring authentication, the server responds with a 200.
     *
     * @dataProvider dataProviderForAlg
     * @param string $alg
     * @return void
     */
    public function test_auth_works(string $alg): void
    {
        $alg === 'RS' ? TestHelper::createRs256Config() : TestHelper::createHs256Config();
        $this->post('/test/login.json', ['email' => 'test@example.com', 'password' => 'password']);
        $this->assertResponseCode(200);
        $body = (string)$this->_response->getBody();
        $this->configRequest([
            'headers' => ['Authorization' => 'Bearer ' . $body],
        ]);

        $this->get('/test/index.json');
        $this->assertResponseOk();
    }

    /**
     * When an unauthenticated request is made to an endpoint requiring authentication, the server responds with a 401.
     *
     * @dataProvider dataProviderForAlg
     * @param string $alg
     * @return void
     */
    public function test_auth_required(string $alg): void
    {
        $alg === 'RS' ? TestHelper::createRs256Config() : TestHelper::createHs256Config();
        $this->get('/test/index.json');
        $this->assertResponseContains('Authentication is required to continue');

    }

    public function dataProviderForAlg(): array
    {
        return [
            ['HS'],['RS']
        ];
    }
}
