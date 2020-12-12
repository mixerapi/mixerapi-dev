<?php

namespace MixerApi\Rest\Test\TestCase\Command;

use Cake\Routing\Route\Route;
use Cake\Routing\Router;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

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

    public function testExecute()
    {
        $this->exec('mixerapi:rest route list');
        $this->assertOutputContains('actors:index', 'route name');
        $this->assertOutputContains('actors', 'uri template');
        $this->assertOutputContains('GET', 'method(s)');
        $this->assertOutputContains('Actors', 'controller');
    }

    public function testExecutePlugin()
    {
        $this->exec('mixerapi:rest route list --plugin App');
        $this->assertOutputContains('actors:index', 'route name');
        $this->assertOutputContains('actors', 'uri template');
        $this->assertOutputContains('GET', 'method(s)');
        $this->assertOutputContains('Actors', 'controller');
    }

    public function testExecuteRoutesNotFound()
    {
        $this->exec('mixerapi:rest route list --reloadRoutes');
        $this->assertExitError();
    }
}