<?php
declare(strict_types=1);

namespace TestApp\Model\Entity;

use Cake\ORM\Entity;
use MixerApi\JsonLdView\JsonLdDataInterface;
use Cake\Datasource\EntityInterface;
use MixerApi\JsonLdView\JsonLdSchema;

class Actor extends Entity implements JsonLdDataInterface
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
        'first_name' => true,
        'last_name' => true,
        'modified' => true,
        'film_actors' => true,
    ];

    /**
     * @return string
     */
    public function getJsonLdContext(): string
    {
        return '/contexts/Actor';
    }

    /**
     * @return string
     */
    public function getJsonLdType(): string
    {
        return 'https://schema.org/Actor';
    }

    /**
     * @param EntityInterface $entity
     * @return array|\string[][]
     */
    public function getJsonLdIdentifier(EntityInterface $entity): string
    {
        return '/actors/' . $entity->get('id');
    }

    /**
     * @return \MixerApi\JsonLdView\JsonLdSchema[]
     */
    public function getJsonLdSchemas(): array
    {
        return [
            (new JsonLdSchema())->setProperty('first_name')->setSchemaUrl('https://schema.org/givenName'),
            (new JsonLdSchema())->setProperty('last_name')->setSchemaUrl('https://schema.org/familyName'),
        ];
    }
}
