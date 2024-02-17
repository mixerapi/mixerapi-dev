<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Test\Fixture;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\TestSuite\Fixture\TestFixture;

class UsersFixture extends TestFixture
{
    /**
     * @inheritdoc
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 'fe4f2385-0473-4973-af4d-f7c266235031',
                'email' => 'test@example.com',
                'password' => (new DefaultPasswordHasher)->hash('password'),
                'created' => '2006-02-15 04:34:33',
                'modified' => '2006-02-15 04:34:33',
            ]
        ];
        parent::init();
    }
}
