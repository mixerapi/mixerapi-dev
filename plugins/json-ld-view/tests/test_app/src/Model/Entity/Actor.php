<?php
declare(strict_types=1);

namespace MixerApi\JsonLdView\Test\App\Model\Entity;

use Cake\ORM\Entity;
use MixerApi\JsonLdView\JsonLdDataInterface;
use Cake\Datasource\EntityInterface;
use MixerApi\JsonLdView\JsonLdSchema;

class Actor extends Entity implements JsonLdDataInterface
{
    /**
     * @inheritDoc
     */
    protected array $_accessible = [
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
        return '/contexts/Actors';
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
     * @return string
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
            new JsonLdSchema('first_name', 'https://schema.org/givenName'),
            new JsonLdSchema('last_name', 'https://schema.org/familyName')
        ];
    }
}
