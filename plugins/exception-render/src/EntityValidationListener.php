<?php
declare(strict_types=1);

namespace MixerApi\ExceptionRender;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\Event\EventManager;
use ReflectionClass;
use ReflectionException;

class EntityValidationListener
{
    /**
     * EntityValidationListener constructor.
     */
    public function __construct()
    {
        EventManager::instance()->on(
            'Model.afterMarshal',
            function ($event, $entity, $options) {
                $this->handler($event, $entity, $options);
            }
        );
    }

    /**
     * @param \Cake\Event\EventInterface $event EventInterface
     * @param \Cake\Datasource\EntityInterface $entity EntityInterface
     * @param \ArrayObject $options options
     * @return void
     */
    private function handler(EventInterface $event, EntityInterface $entity, ArrayObject $options): void
    {
        if (!$entity->hasErrors()) {
            return;
        }

        try {
            $name = (new ReflectionClass($entity))->getShortName();
            // skipping since ReflectionException is unlikely to be raised
            // @codeCoverageIgnoreStart
        } catch (ReflectionException $e) {
            $name = get_class($entity);
            // @codeCoverageIgnoreEnd
        }

        throw new ValidationException(
            $entity,
            sprintf('Error saving resource `%s`', $name)
        );
    }
}
