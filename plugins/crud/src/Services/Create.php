<?php
declare(strict_types=1);

namespace MixerApi\Crud\Services;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
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
     * @param \MixerApi\Crud\DeserializerInterface|null $deserializer The DeserializerInterface used to deserialize
     * the request body.
     */
    public function __construct(
        private ?DeserializerInterface $deserializer = null
    ) {
        $this->deserializer = $deserializer ?? new Deserializer();
    }

    /**
     * @inheritDoc
     */
    public function save(Controller $controller, \ArrayAccess|array $options = []): EntityInterface
    {
        $this->allowMethods($controller);
        $table = $controller->getTableLocator()->get($this->whichTable($controller));

        $entity = $table->patchEntity(
            $table->newEmptyEntity(),
            $this->deserializer->deserialize($controller->getRequest())
        );

        $entity = $table->save($entity, $options);

        if (!$entity) {
            throw new ResourceWriteException(null, "Unable to save $this->tableName resource.");
        }

        return $entity;
    }
}
