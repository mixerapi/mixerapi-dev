<?php
declare(strict_types=1);

namespace MixerApi\Crud\Services;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\TableRegistry;
use MixerApi\Crud\Deserializer;
use MixerApi\Crud\DeserializerInterface;
use MixerApi\Crud\Exception\ResourceWriteException;
use MixerApi\Crud\Interfaces\CreateInterface;

/**
 * Implements CreateInterface and provides record creation functionality.
 *
 * @experimental
 */
class Create implements CreateInterface
{
    use CrudTrait;

    /**
     * @param \Cake\ORM\Locator\LocatorInterface|null $locator LocatorInterface to find the table that records will
     * be created in.
     * @param \MixerApi\Crud\DeserializerInterface|null $deserializer The DeserializerInterface used to deserialize
     * the request body.
     */
    public function __construct(
        private ?LocatorInterface $locator = null,
        private ?DeserializerInterface $deserializer = null
    ) {
        $this->locator = $locator ?? TableRegistry::getTableLocator();
        $this->deserializer = $deserializer ?? new Deserializer();
    }

    /**
     * @inheritDoc
     */
    public function save(Controller $controller): EntityInterface
    {
        $this->allowMethods($controller);

        $table = $this->locator->get($this->whichTable($controller));

        $entity = $table->patchEntity(
            $table->newEmptyEntity(),
            $this->deserializer->deserialize($controller->getRequest())
        );

        $entity = $table->save($entity);

        if (!$entity) {
            throw new ResourceWriteException(null, "Unable to save $this->tableName resource.");
        }

        return $entity;
    }
}
