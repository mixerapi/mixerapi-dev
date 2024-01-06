<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Test\App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Text;
use MixerApi\JwtAuth\Jwt\Jwt;
use MixerApi\JwtAuth\Jwt\JwtEntityInterface;
use MixerApi\JwtAuth\Jwt\JwtInterface;

/**
 * User Entity
 *
 * @property string $id
 * @property string $email
 * @property string $password
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 */
class User extends Entity implements JwtEntityInterface
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'email' => true,
        'password' => true,
        'created' => true,
        'modified' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected array $_hidden = [
        'password',
    ];

    /**
     * @inheritDoc
     */
    public function getJwt(): JwtInterface
    {
        return new Jwt(
            time() + 60 * 60 * 24,
            $this->get('id'),
            'mixerapi',
            'api-client',
            null,
            time(),
            Text::uuid(),
            [
                'user' => [
                    'email' => $this->get('email')
                ]
            ]
        );
    }
}
