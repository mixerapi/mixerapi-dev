<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Test;

use Cake\Core\Configure;
use Cake\Utility\Security;
use MixerApi\JwtAuth\Jwt\Jwt;
use MixerApi\JwtAuth\Jwt\JwtInterface;

class TestHelper
{
    public static function createRs256Config(?array $keys = null): void
    {
        Configure::delete('MixerApi.JwtAuth');
        Configure::write('MixerApi.JwtAuth', [
            'alg' => 'RS256',
            'keys' => $keys ?? [
                [
                    'kid' => '1',
                    'public' => file_get_contents(__DIR__ . '/keys/1/public.pem'),
                    'private' => file_get_contents(__DIR__ . '/keys/1/private.pem'),
                ],
                [
                    'kid' => '2',
                    'public' => file_get_contents(__DIR__ . '/keys/1/public.pem'),
                    'private' => file_get_contents(__DIR__ . '/keys/1/private.pem'),
                ],
                [
                    'kid' => '3',
                    'public' => file_get_contents(__DIR__ . '/keys/1/public.pem'),
                    'private' => file_get_contents(__DIR__ . '/keys/1/private.pem'),
                ],
            ],
        ]);
    }

    public static function createHs256Config(): void
    {
        Configure::delete('MixerApi.JwtAuth');
        Configure::write('MixerApi.JwtAuth', [
            'alg' => 'HS256',
            'secret' => Security::getSalt(),
        ]);
    }

    public static function createJwt(): JwtInterface
    {
        return new Jwt(
            time() + 60 * 60 *24,
            '123',
            null,
        null,
            null,
            null,
            null,
            ['user' => ['data']]
        );
    }
}
