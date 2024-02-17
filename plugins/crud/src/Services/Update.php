<?php
declare(strict_types=1);

namespace MixerApi\Crud\Services;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
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
     * @param \MixerApi\Crud\Services\Read|null $read The Read service that will find the record to be updated.
     * @param \MixerApi\Crud\DeserializerInterface|null $deserializer The DeserializerInterface used to deserialize
     * the request body.
     */
    public function __construct(
        private ?Read $read = null,
        private ?DeserializerInterface $deserializer = null
    ) {
        $this->read = $read ?? new Read();
        $this->deserializer = $deserializer ?? new Deserializer();
    }

    /**
     * @inheritDoc
     */
    public function save(Controller $controller, mixed $id = null, \ArrayAccess|array $options = []): EntityInterface
    {
        $this->allowMethods($controller);

        $table = $controller->getTableLocator()->get($this->whichTable($controller));

        $id = $this->whichId($controller, $id);

        $entity = $table->patchEntity(
            $this->read->read($controller, $id),
            $this->deserializer->deserialize($controller->getRequest())
        );

        $entity = $table->save($entity, $options);

        if (!$entity) {
            throw new ResourceWriteException(null, "Unable to save $this->tableName resource.");
        }

        return $entity;
    }
}
