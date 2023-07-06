<?php
declare(strict_types=1);

namespace MixerApi\Core\Test\App\Model\Entity;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Entity;

class Film extends Entity
{
    /**
     * @inheritdoc
     */
    protected array $_accessible = [
        'title' => true,
        'description' => true,
        'release_year' => true,
        'language_id' => true,
        'rental_duration' => true,
        //'rental_rate' => true,
        'length' => true,
        //'replacement_cost' => true,
        'rating' => true,
        'special_features' => true,
        'modified' => true,
        'language' => true,
        'film_actors' => true,
        'film_categories' => true,
        'film_texts' => true,
        'inventories' => true,
    ];

    protected array $_hidden = ['_joinData'];

    public function getHalLinks(EntityInterface $entity): array
    {
        return [
            'self' => [
                'href' => '/films/' . $entity->get('id')
            ]
        ];
    }
}
