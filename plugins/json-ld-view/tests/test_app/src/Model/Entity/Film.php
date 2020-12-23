<?php
declare(strict_types=1);

namespace MixerApi\JsonLdView\Test\App\Model\Entity;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Entity;
use MixerApi\JsonLdView\JsonLdDataInterface;
use MixerApi\JsonLdView\JsonLdSchema;

class Film extends Entity implements JsonLdDataInterface
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
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

    protected $_hidden = ['_joinData'];

    /**
     * @return string
     */
    public function getJsonLdContext(): string
    {
        return '/contexts/Film';
    }

    /**
     * @return string
     */
    public function getJsonLdType(): string
    {
        return 'https://schema.org/movie';
    }
    /**
     * @param EntityInterface $entity
     * @return array|\string[][]
     */
    public function getJsonLdIdentifier(EntityInterface $entity): string
    {
        return '/films/' . $entity->get('id');
    }

    /**
     * @return \MixerApi\JsonLdView\JsonLdSchema[]
     */
    public function getJsonLdSchemas(): array
    {
        return [
            (new JsonLdSchema())->setProperty('title')->setSchemaUrl('https://schema.org/name'),
            (new JsonLdSchema())->setProperty('description')->setSchemaUrl('https://schema.org/about'),
            (new JsonLdSchema())->setProperty('length')->setSchemaUrl('https://schema.org/duration'),
            (new JsonLdSchema())->setProperty('rating')->setSchemaUrl('https://schema.org/contentRating'),
            (new JsonLdSchema())->setProperty('release_year')->setSchemaUrl('https://schema.org/copyrightYear'),
        ];
    }
}
