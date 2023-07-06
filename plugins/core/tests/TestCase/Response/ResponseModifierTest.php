<?php

namespace MixerApi\Core\Test\TestCase\Response;

use Cake\Event\EventManager;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use MixerApi\Core\Response\ResponseModifier;
use ReflectionFunction;

class ResponseModifierTest extends TestCase
{
    public function test_event_listener(): void
    {
        $modifier = new ResponseModifier('jsonld', 'MixerApi/JsonLdView.JsonLd');
        $modifier->listen();
        $eventManager = EventManager::instance();
        $listeners = $eventManager->matchingListeners('Controller.initialize');
        $names = [];
        foreach ($listeners['Controller.initialize'] as $listens) {
            foreach ($listens as $listen) {
                $names[] = (new ReflectionFunction($listen['callable']))->name;
            }
        }

        $results = array_filter($names, function($name) {
            return strstr($name, 'MixerApi\Core\Response\{closure}');
        });

        $this->assertNotEmpty($results);
    }
}
