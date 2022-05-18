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
                    'public' => file_get_contents(__DIR__ . '/keys/public-2048.pem'),
                    'private' => file_get_contents(__DIR__ . '/keys/private-2048.pem'),
                ],
                [
                    'kid' => '2',
                    'public' => file_get_contents(__DIR__ . '/keys/public-2048.pem'),
                    'private' => file_get_contents(__DIR__ . '/keys/private-2048.pem'),
                ],
                [
                    'kid' => '3',
                    'public' => file_get_contents(__DIR__ . '/keys/public-2048.pem'),
                    'private' => file_get_contents(__DIR__ . '/keys/private-2048.pem'),
                ],
            ],
        ]);
    }

    public static function createRs256ConfigWithWeakKeys(?array $keys = null): void
    {
        Configure::delete('MixerApi.JwtAuth');
        Configure::write('MixerApi.JwtAuth', [
            'alg' => 'RS256',
            'keys' => $keys ?? [
                    [
                        'kid' => '1',
                        'public' => file_get_contents(__DIR__ . '/keys/public-1024.pem'),
                        'private' => file_get_contents(__DIR__ . '/keys/private-1024.pem'),
                    ]
                ],
        ]);
    }

    public static function createHs256Config(): void
    {
        Configure::delete('MixerApi.JwtAuth');
        Configure::write('MixerApi.JwtAuth', [
            'alg' => 'HS256',
            'secret' => 'a-reasonable-long-secret-is-a-good-secret!',
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
