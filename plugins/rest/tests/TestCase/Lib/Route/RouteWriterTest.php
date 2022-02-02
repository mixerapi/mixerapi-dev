<?php

namespace MixerApi\Rest\Test\TestCase\Lib\Route;

use Cake\TestSuite\TestCase;
use MixerApi\Rest\Lib\Controller\ReflectedControllerDecorator;
use MixerApi\Rest\Lib\Exception\RunTimeException;
use MixerApi\Rest\Lib\Route\ResourceScanner;
use MixerApi\Rest\Lib\Route\RouteDecoratorFactory;
use MixerApi\Rest\Lib\Route\RouteWriter;

class RouteWriterTest extends TestCase
{
    private const ROUTE_BASE = 'routes_base.php';

    private const ROUTE_FILE = 'routes_test.php';

    private const REST_PLUGIN = ROOT . DS . 'plugins' . DS . 'rest' . DS;

    private const MY_PLUGIN = ROOT . DS . 'plugins' . DS . 'rest' . DS . 'tests' . DS . 'plugins' . DS . 'MyPlugin' . DS;

    /**
     * @var string path to plugin config directory
     */
    private string $pluginConfig;

    public function setUp(): void
    {
        parent::setUp();
        $this->pluginConfig = self::MY_PLUGIN . 'config' . DS;

        $config = self::REST_PLUGIN . 'tests' . DS . 'test_app' . DS . 'config' . DS;

        touch($config . self::ROUTE_FILE);
        touch($this->pluginConfig . self::ROUTE_FILE);

        copy($config . self::ROUTE_BASE, $config . self::ROUTE_FILE);
        copy($this->pluginConfig . self::ROUTE_BASE, $this->pluginConfig . self::ROUTE_FILE);
    }

    public function test_construct(): void
    {
        $resourceScanner = new ResourceScanner('MixerApi\Rest\Test\App\Controller');
        $resources = $resourceScanner->getControllerDecorators();

        $config = self::REST_PLUGIN . 'tests' . DS . 'test_app' . DS . 'config'  . DS;

        $routeWriter = new RouteWriter(
            $resources,
            'MixerApi\Rest\Test\App\Controller',
            $config,
            '/'
        );

        $this->assertEquals($resources, $routeWriter->getResources());
        $this->assertEquals($config, $routeWriter->getConfigDir());
        $this->assertEquals('/', $routeWriter->getPrefix());
    }

    public function test_construct_exception(): void
    {
        $this->expectException(RunTimeException::class);

        $namespace = 'MixerApi\Rest\Test\App\Controller';

        $resources = (new ResourceScanner($namespace))->getControllerDecorators();

        new RouteWriter($resources, $namespace, '/nope/and/nope', '/');
    }

    /**
     * Test merge on regular App\Controller with sub controllers
     */
    public function test_merge(): void
    {
        $namespace = 'MixerApi\Rest\Test\App\Controller';

        $resources = (new ResourceScanner($namespace))->getControllerDecorators();

        $config = self::REST_PLUGIN . 'tests' . DS . 'test_app' . DS . 'config' . DS;

        (new RouteWriter($resources, $namespace, $config, '/'))->merge(self::ROUTE_FILE);

        $contents = file_get_contents($config . self::ROUTE_FILE);

        $this->assertTextContains("\$builder->resources('Actors')", $contents);
        $this->assertTextContains("\$builder->resources('Films')", $contents);
        $this->assertTextContains(
            "\$builder->resources('Cities', ['path' => 'countries/cities', 'prefix' => 'Countries']);",
            $contents
        );
        $this->assertTextContains(
            "\$builder->resources('Languages', ['path' => 'sub/languages', 'prefix' => 'Sub']);",
            $contents
        );
    }

    /**
     * Test merge on regular Plugin\Controller
     */
    public function test_plugin(): void
    {
        $namespace = 'MixerApi\Rest\Test\MyPlugin\Controller';

        $resources = (new ResourceScanner($namespace))->getControllerDecorators();

        $routeWriter = new RouteWriter(
            $resources,
            $namespace,
            $this->pluginConfig,
            '/my-plugin',
            'MyPlugin'
        );

        $routeWriter->merge(self::ROUTE_FILE);

        $contents = file_get_contents($this->pluginConfig . self::ROUTE_FILE);
        $this->assertTextContains("\$builder->resources('Countries')", $contents);
        $this->assertTextContains("Router::plugin('MyPlugin', ['path' => '/my-plugin'],", $contents);
    }

    /**
     * Undefined scope prefix throws exception
     */
    public function test_undefined_scope(): void
    {
        $this->expectException(\MixerApi\Rest\Lib\Exception\RouteScopeNotFound::class);
        $namespace = 'MixerApi\Rest\Test\App\Controller';

        $resources = (new ResourceScanner($namespace))->getControllerDecorators();

        $config = self::REST_PLUGIN . 'tests' . DS . 'test_app' . DS . 'config' . DS;

        (new RouteWriter($resources, $namespace, $config, '/nope'))->merge(self::ROUTE_FILE);

        $contents = file_get_contents($config . self::ROUTE_FILE);

        echo $contents; die;
    }

    /**
     * Undefined plugin scope throws exception
     */
    public function test_undefined_plugin_scope(): void
    {
        $this->expectException(\MixerApi\Rest\Lib\Exception\RouteScopeNotFound::class);
        $namespace = 'MixerApi\Rest\Test\App\Controller';

        $resources = (new ResourceScanner($namespace))->getControllerDecorators();

        $config = self::REST_PLUGIN . 'tests' . DS . 'test_app' . DS . 'config' . DS;

        (new RouteWriter($resources, $namespace, $config, '/', 'Nope'))->merge(self::ROUTE_FILE);

        $contents = file_get_contents($config . self::ROUTE_FILE);

        echo $contents; die;
    }
}
