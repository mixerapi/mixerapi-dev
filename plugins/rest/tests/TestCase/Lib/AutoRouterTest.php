<?php

namespace MixerApi\Rest\Test\TestCase\Lib;

use Cake\TestSuite\TestCase;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use MixerApi\Rest\Lib\AutoRouter;
use MixerApi\Rest\Lib\Route\ResourceScanner;
use ReflectionClass;

class AutoRouterTest extends TestCase
{
    public function test_build_resources(): void
    {
        $scanner = new ResourceScanner('MixerApi\Rest\Test\App\Controller');
        $routes = new RouteBuilder(Router::getRouteCollection(),'/');
        $routes->setRouteClass(DashedRoute::class);
        $routes->scope('/', function (RouteBuilder $builder) use ($scanner) {
            $builder->fallbacks();
            (new AutoRouter($builder, $scanner))->buildResources();
        });

        $collection = Router::getRouteCollection();
        $reflection = new ReflectionClass($collection);
        $property = $reflection->getProperty('_routeTable');
        $property->setAccessible(true);
        $routeTable = $property->getValue($collection);

        $this->assertArrayHasKey('actors:index', $routeTable);
        $this->assertArrayHasKey('countries:cities:index', $routeTable);
        $this->assertArrayHasKey('sub:languages:index', $routeTable);
        $this->assertArrayNotHasKey('no-crud:nope', $routeTable);
    }
}
