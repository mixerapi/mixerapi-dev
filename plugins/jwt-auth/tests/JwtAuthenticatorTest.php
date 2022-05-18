<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Test;

use Authentication\Authenticator\Result;
use Authentication\Authenticator\UnauthenticatedException;
use Authentication\Controller\Component\AuthenticationComponent;
use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use MixerApi\JwtAuth\Configuration\Configuration;
use MixerApi\JwtAuth\Exception\JwtAuthException;
use MixerApi\JwtAuth\JwtAuthenticator;
use MixerApi\JwtAuth\Test\Classes\BadEntity;
use MixerApi\JwtAuth\Test\Classes\JwtEntity;

class JwtAuthenticatorTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Configure::delete('MixerApi.JwtAuth');
    }

    /**
     * @dataProvider dataProviderForAlg
     */
    public function test_authenticate_with_jwt_interface(string $alg): void
    {
        $alg === 'HS256' ? TestHelper::createHs256Config() : TestHelper::createRs256Config();
        $token = (new JwtAuthenticator(new Configuration))->authenticate(TestHelper::createJwt());
        $this->assertIsString($token);
    }

    /**
     * @dataProvider dataProviderForAlg
     */
    public function test_authenticate_with_auth_component(string $alg): void
    {
        $alg === 'HS256' ? TestHelper::createHs256Config() : TestHelper::createRs256Config();
        $mock = $this->createPartialMock(AuthenticationComponent::class, ['getResult']);
        $mock->expects($this->once())
            ->method('getResult')
            ->willReturn(new Result(new JwtEntity(), Result::SUCCESS));

        $token = (new JwtAuthenticator(new Configuration))->authenticate($mock);
        $this->assertIsString($token);
    }

    /**
     * @dataProvider dataProviderForResultMessages
     */
    public function test_authenticate_throws_unauthenticated_exception(array $messages): void
    {
        TestHelper::createHs256Config();
        $mock = $this->createPartialMock(AuthenticationComponent::class, ['getResult']);
        $mock->expects($this->once())
            ->method('getResult')
            ->willReturn(new Result(new JwtEntity(), Result::FAILURE_CREDENTIALS_INVALID, $messages));

        $this->expectException(UnauthenticatedException::class);
        (new JwtAuthenticator(new Configuration))->authenticate($mock);
    }

    public function test_authenticate_throws_exception_when_entity_is_invalid(): void
    {
        TestHelper::createHs256Config();
        $mock = $this->createPartialMock(AuthenticationComponent::class, ['getResult']);
        $mock->expects($this->once())
            ->method('getResult')
            ->willReturn(new Result(new BadEntity(), Result::SUCCESS));

        $this->expectException(JwtAuthException::class);
        (new JwtAuthenticator(new Configuration))->authenticate($mock);
    }

    public function dataProviderForAlg(): array
    {
        return [
            ['RS256'],
            ['HS256'],
        ];
    }

    public function dataProviderForResultMessages(): array
    {
        return [
            [[]],
            [['An error.', 'Another error.',]],
        ];
    }
}
