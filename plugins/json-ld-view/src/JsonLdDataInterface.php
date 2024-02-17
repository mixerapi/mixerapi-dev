<?php
declare(strict_types=1);

namespace MixerApi\JsonLdView;

use Cake\Datasource\EntityInterface;

/**
 * This interface must be implemented on Cake\ORM\Entity classes for them to be converted into JSON-LD.
 */
interface JsonLdDataInterface
{
    /**
     * Returns an identifier for the ID or UUID of the entity. This should be a URL such as `/my-entity/803`.
     *
     * @param \Cake\Datasource\EntityInterface $entity EntityInterface
     * @return string
     */
    public function getJsonLdIdentifier(EntityInterface $entity): string;

    /**
     * Returns a context for the entity such as /contexts/Actors which would return as
     * `"@context": "/contexts/Actors"`. The context should be in plural form i.e. Actors instead of Actor.
     *
     * @return string
     */
    public function getJsonLdContext(): string;

    /**
     * Returns a context for the entity such as https://schema.org/Person which would return as
     * `"@type": "http://schema.org/Person"`
     *
     * @return string
     */
    public function getJsonLdType(): string;

    /**
     * Returns an array of JsonLdSchema instances
     *
     * @see \MixerApi\JsonLdView\JsonLdSchema
     * @return \MixerApi\JsonLdView\JsonLdSchema[]
     */
    public function getJsonLdSchemas(): array;
}
