<?php
declare(strict_types=1);

namespace MixerApi\HalView;

use Cake\Datasource\EntityInterface;

/**
 * This interface must be implemented on Cake\ORM\Entity classes for them to be converted into HAL resources
 */
interface HalResourceInterface
{
    /**
     * Returns the Entities links. Return an empty array if you do not want links defined.
     *
     * Returning: ['self' => ['href' => '/actors/' . $entity->get('id')]]
     * Generates: {"_links": {"self": {"href": "/actors/123"}}}
     *
     * @param \Cake\Datasource\EntityInterface $entity an instance of the Entity
     * @return string[]
     */
    public function getHalLinks(EntityInterface $entity): array;

    // phpcs:disable
    /**
     * Return an array of curies to be set. Return an empty array if you don't want curies defined.
     *
     * @example
     * Return: [['name' => '/actors/{id}', 'href' => 'http://docs.example.org/', templated => true]]
     * Hal+Json: {"_links": {"curies": [{"name": "doc", "href": "http://docs.example.org/", "templated": true}]} }
     *
     * @return string[]
     * @phpcs
     */
    //public function getHalCuries() : array;
    // phpcs:enable
}
