<?php

namespace MixerApi\Rest\Test\TestCase\Command;

use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;
use MixerApi\Rest\Command\ListRoutesCommand;

class ListRoutesCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    public $fixtures = [
        'plugin.MixerApi/Rest.Actors'
    ];

    public function setUp() : void
    {
        parent::setUp();
        $this->setAppNamespace('MixerApi\Rest\Test\App');
        $this->useCommandRunner();
    }

    public function test_execute(): void
    {
        $this->exec('mixerapi:rest route list');
        $this->assertOutputContains('actors:index', 'route name');
        $this->assertOutputContains('actors', 'uri template');
        $this->assertOutputContains('GET', 'method(s)');
        $this->assertOutputContains('Actors', 'controller');
    }

    public function test_execute_plugin(): void
    {
        $this->exec('mixerapi:rest route list --plugin App');
        $this->assertOutputContains('actors:index', 'route name');
        $this->assertOutputContains('actors', 'uri template');
        $this->assertOutputContains('GET', 'method(s)');
        $this->assertOutputContains('Actors', 'controller');
    }

    public function test_execute_routes_not_found(): void
    {
        $this->exec('mixerapi:rest route list --reloadRoutes');
        $this->assertOutputContains(ListRoutesCommand::NO_ROUTES_FOUND);
        $this->assertExitError();
    }
}
