<?php
declare(strict_types=1);

namespace MixerApi\Core\Test\App\Event;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;

class ModelListener implements EventListenerInterface
{
    public function implementedEvents(): array
    {
        return [
            'Model.initialize' => 'eventListenerLoaderTest'
        ];
    }

    /**
     * @param Event $event
     */
    public function eventListenerLoaderTest(Event $event)
    {

    }
}
