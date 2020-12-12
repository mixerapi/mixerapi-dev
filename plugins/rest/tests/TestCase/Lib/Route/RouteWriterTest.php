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

    private $pluginConfig;

    public function setUp(): void
    {
        parent::setUp();
        $this->pluginConfig = TEST . 'plugins' . DS . 'MyPlugin' . DS . 'config' . DS;

        touch(CONFIG . self::ROUTE_FILE);
        touch($this->pluginConfig . self::ROUTE_FILE);

        copy(CONFIG . self::ROUTE_BASE, CONFIG . self::ROUTE_FILE);
        copy($this->pluginConfig . self::ROUTE_BASE, $this->pluginConfig . self::ROUTE_FILE);
    }

    public function testConstruct()
    {
        $resourceScanner = new ResourceScanner('MixerApi\Rest\Test\App\Controller');
        $resources = $resourceScanner->getControllerDecorators();

        $routeWriter = new RouteWriter(
            $resources,
            'MixerApi\Rest\Test\App\Controller',
            CONFIG,
            '/'
        );

        $this->assertEquals($resources, $routeWriter->getResources());
        $this->assertEquals(CONFIG, $routeWriter->getConfigDir());
        $this->assertEquals('/', $routeWriter->getPrefix());
    }

    public function testConstructException()
    {
        $this->expectException(RunTimeException::class);

        $namespace = 'MixerApi\Rest\Test\App\Controller';

        $resources = (new ResourceScanner($namespace))->getControllerDecorators();

        new RouteWriter($resources, $namespace, '/nope/and/nope', '/');
    }

    /**
     * Test merge on regular App\Controller with sub controllers
     */
    public function testMerge()
    {
        $namespace = 'MixerApi\Rest\Test\App\Controller';

        $resources = (new ResourceScanner($namespace))->getControllerDecorators();

        (new RouteWriter($resources, $namespace, CONFIG, '/'))->merge(self::ROUTE_FILE);

        $contents = file_get_contents(CONFIG . self::ROUTE_FILE);

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
    public function testPlugin()
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
    public function testUndefinedScope()
    {
        $this->expectException(\MixerApi\Rest\Lib\Exception\RouteScopeNotFound::class);
        $namespace = 'MixerApi\Rest\Test\App\Controller';

        $resources = (new ResourceScanner($namespace))->getControllerDecorators();

        (new RouteWriter($resources, $namespace, CONFIG, '/nope'))->merge(self::ROUTE_FILE);

        $contents = file_get_contents(CONFIG . self::ROUTE_FILE);

        echo $contents; die;
    }

    /**
     * Undefined plugin scope throws exception
     */
    public function testUndefinedPluginScope()
    {
        $this->expectException(\MixerApi\Rest\Lib\Exception\RouteScopeNotFound::class);
        $namespace = 'MixerApi\Rest\Test\App\Controller';

        $resources = (new ResourceScanner($namespace))->getControllerDecorators();

        (new RouteWriter($resources, $namespace, CONFIG, '/', 'Nope'))->merge(self::ROUTE_FILE);

        $contents = file_get_contents(CONFIG . self::ROUTE_FILE);

        echo $contents; die;
    }
}