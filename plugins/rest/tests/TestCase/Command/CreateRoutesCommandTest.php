<?php

namespace MixerApi\Rest\Test\TestCase\Command;

use Cake\Core\Configure;
use Cake\Routing\Route\Route;
use Cake\Routing\Router;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;
use MixerApi\Rest\Lib\Exception\RunTimeException;

class CreateRoutesCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    public $fixtures = [
        'plugin.MixerApi/Rest.Actors'
    ];

    private const ROUTE_FILE = 'routes_test.php';
    private const ROUTE_BASE = 'routes_base.php';

    public function setUp() : void
    {
        parent::setUp();
        $this->setAppNamespace('MixerApi\Rest\Test\App');
        $this->useCommandRunner();
        $pluginConfig = TEST . 'plugins' . DS . 'MyPlugin' . DS . 'config' . DS;

        touch(CONFIG . self::ROUTE_FILE);
        touch($pluginConfig . self::ROUTE_FILE);

        copy(CONFIG . self::ROUTE_BASE, CONFIG . self::ROUTE_FILE);
        copy($pluginConfig . self::ROUTE_BASE, $pluginConfig . self::ROUTE_FILE);
    }

    public function testSuccess()
    {
        $file = self::ROUTE_FILE;
        $this->exec("mixerapi:rest route create --routesFile $file", ['Y']);
        $this->assertOutputContains('Routes were written');
        $this->assertExitSuccess();
    }

    public function testPluginSuccess()
    {
        $file = self::ROUTE_FILE;
        $ns = 'MixerApi\Rest\Test\MyPlugin\Controller';
        $plugin = 'MyPlugin';
        $this->exec("mixerapi:rest route create --namespace $ns --routesFile $file --plugin $plugin", ['Y']);
        $this->assertOutputContains('Routes were written');
        $this->assertExitSuccess();
    }

    public function testDisplaySuccess()
    {
        $this->exec("mixerapi:rest route create --display");
        $this->assertOutputContains('actors:index', 'route name');
        $this->assertOutputContains('actors', 'uri template');
        $this->assertOutputContains('GET', 'method(s)');
        $this->assertOutputContains('Actors', 'controller');
        $this->assertExitSuccess();
    }

    public function testAbort()
    {
        $file = self::ROUTE_FILE;
        $this->exec("mixerapi:rest route create --routesFile $file", ['N']);
        $this->assertExitError();
    }

    public function testNoControllersExitError()
    {
        $file = self::ROUTE_FILE;
        $this->exec("mixerapi:rest route create --routesFile $file --plugin Nope", ['Y']);
        $this->assertExitError();
    }
}