<?php
declare(strict_types=1);

namespace MixerApi\Core\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use MixerApi\Core\Utility\NamespaceUtility;
use ReflectionClass;

class EventListenerLoader
{
    /**
     * Loads event listeners
     *
     * @param string $namespace defaults to App\Event
     * @return void
     * @throws \ReflectionException
     */
    public function load(string $namespace = 'App\Event'): void
    {
        $events = NamespaceUtility::findClasses($namespace);
        foreach ($events as $event) {
            if ((new ReflectionClass($event))->implementsInterface(EventListenerInterface::class)) {
                EventManager::instance()->on(new $event());
            }
        }
    }
}
