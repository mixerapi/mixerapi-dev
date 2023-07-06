<?php
declare(strict_types=1);

namespace MixerApi\Core\Test\App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Datasource\EntityInterface;

class Actor extends Entity
{
    /**
     * @inheritdoc
     */
    protected array $_accessible = [
        'first_name' => true,
        'last_name' => true,
        'write' => true,
        '*' => false
    ];

    /**
     * @inheritdoc
     */
    protected array $_hidden = [
        'hide', 'write'
    ];

    /**
     * @param EntityInterface $entity
     * @return array|\string[][]
     */
    public function getHalLinks(EntityInterface $entity): array
    {
        return [
            'self' => [
                'href' => '/actors/' . $entity->get('id')
            ]
        ];
    }
}
