<?php
declare(strict_types=1);

namespace MixerApi\Crud\Services;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\TableRegistry;
use MixerApi\Crud\Deserializer;
use MixerApi\Crud\Exception\ResourceWriteException;
use MixerApi\Crud\Interfaces\UpdateInterface;

/**
 * @experimental
 */
class Update implements UpdateInterface
{
    use CrudTrait;

    /**
     * @var \Cake\ORM\Locator\LocatorInterface
     */
    private $locator;

    /**
     * @var \MixerApi\Crud\Services\Read
     */
    private $read;

    /**
     * @var \MixerApi\Crud\Deserializer
     */
    private $deserializer;

    /**
     * @param \Cake\ORM\Locator\LocatorInterface|null $locator locator
     * @param \MixerApi\Crud\Services\Read|null $read read service
     * @param \MixerApi\Crud\Deserializer|null $deserializer deserializer
     */
    public function __construct(
        ?LocatorInterface $locator = null,
        ?Read $read = null,
        ?Deserializer $deserializer = null
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
            throw new ResourceWriteException($entity, "Unable to save $this->tableName resource.");
        }

        return $entity;
    }
}
