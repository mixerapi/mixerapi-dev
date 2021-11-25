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

    private const REST_PLUGIN = ROOT . DS . 'plugins' . DS . 'rest' . DS;

    private const MY_PLUGIN = ROOT . DS . 'plugins' . DS . 'rest' . DS . 'tests' . DS . 'plugins' . DS . 'MyPlugin' . DS;

    public function setUp() : void
    {
        parent::setUp();
        $this->setAppNamespace('MixerApi\Rest\Test\App');
        $this->useCommandRunner();
        $pluginConfig = self::MY_PLUGIN . 'config' . DS;

        $config = self::REST_PLUGIN . 'tests' . DS . 'test_app' . DS . 'config' . DS;

        touch($config . self::ROUTE_FILE);
        touch($pluginConfig . self::ROUTE_FILE);

        copy($config . self::ROUTE_BASE, $config . self::ROUTE_FILE);
        copy($pluginConfig . self::ROUTE_BASE, $pluginConfig . self::ROUTE_FILE);
    }

    public function test_success(): void
    {
        $file = self::ROUTE_FILE;
        $configPath = self::REST_PLUGIN . DS . 'tests' . DS . 'test_app' . DS . 'config' . DS;

        $this->exec("mixerapi:rest route create --configPath $configPath --routesFile $file", ['Y']);
        $this->assertOutputContains('Routes were written');
        $this->assertExitSuccess();
    }

    public function test_plugin_success(): void
    {
        $file = self::ROUTE_FILE;
        $ns = 'MixerApi\Rest\Test\MyPlugin\Controller';
        $plugin = 'MyPlugin';
        $configPath = self::MY_PLUGIN . DS . 'config' . DS;
        $this->exec(
            "mixerapi:rest route create --namespace $ns --configPath $configPath  --routesFile $file --plugin $plugin",
            ['Y']
        );
        $this->assertOutputContains('Routes were written');
        $this->assertExitSuccess();
    }

    public function test_display_success(): void
    {
        $this->exec("mixerapi:rest route create --display");
        $this->assertOutputContains('actors:index', 'route name');
        $this->assertOutputContains('actors', 'uri template');
        $this->assertOutputContains('GET', 'method(s)');
        $this->assertOutputContains('Actors', 'controller');
        $this->assertExitSuccess();
    }

    public function test_abort(): void
    {
        $file = self::ROUTE_FILE;
        $this->exec("mixerapi:rest route create --routesFile $file", ['N']);
        $this->assertExitError();
    }

    public function test_no_controllers_exit_error(): void
    {
        $file = self::ROUTE_FILE;
        $this->exec("mixerapi:rest route create --routesFile $file --plugin Nope", ['Y']);
        $this->assertExitError();
    }
}
