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
use MixerApi\Crud\Interfaces\UpdateInterface;

/**
 * Implements UpdateInterface and updates records.
 *
 * @experimental
 */
class Update implements UpdateInterface
{
    use CrudTrait;

    /**
     * @param \Cake\ORM\Locator\LocatorInterface|null $locator LocatorInterface to locate the table.
     * @param \MixerApi\Crud\Services\Read|null $read The Read service that will find the record to be updated.
     * @param \MixerApi\Crud\DeserializerInterface|null $deserializer The DeserializerInterface used to deserialize
     * the request body.
     */
    public function __construct(
        private ?LocatorInterface $locator = null,
        private ?Read $read = null,
        private ?DeserializerInterface $deserializer = null
    ) {
        $this->locator = $locator ?? TableRegistry::getTableLocator();
        $this->read = $read ?? new Read();
        $this->deserializer = $deserializer ?? new Deserializer();
    }

    /**
     * @inheritDoc
     */
    public function save(Controller $controller, $id = null): EntityInterface
    {
        $this->allowMethods($controller);

        $table = $this->locator->get($this->whichTable($controller));

        $id = $this->whichId($controller, $id);

        $entity = $table->patchEntity(
            $this->read->read($controller, $id),
            $this->deserializer->deserialize($controller->getRequest())
        );

        $entity = $table->save($entity);

        if (!$entity) {
            throw new ResourceWriteException(null, "Unable to save $this->tableName resource.");
        }

        return $entity;
    }
}
