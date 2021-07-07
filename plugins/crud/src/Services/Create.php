<?php
declare(strict_types=1);

namespace MixerApi\Crud\Services;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\TableRegistry;
use MixerApi\Crud\Deserializer;
use MixerApi\Crud\Exception\ResourceWriteException;
use MixerApi\Crud\Interfaces\CreateInterface;

/**
 * @experimental
 */
class Create implements CreateInterface
{
    use CrudTrait;

    /**
     * @var \Cake\ORM\Locator\LocatorInterface
     */
    private $locator;

    /**
     * @var \MixerApi\Crud\Deserializer
     */
    private $deserializer;

    /**
     * @param \Cake\ORM\Locator\LocatorInterface|null $locator locator
     * @param \MixerApi\Crud\Deserializer|null $deserializer deserializer
     */
    public function __construct(?LocatorInterface $locator = null, ?Deserializer $deserializer = null)
    {
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
            throw new ResourceWriteException($entity, "Unable to save $this->tableName resource.");
        }

        return $entity;
    }
}
