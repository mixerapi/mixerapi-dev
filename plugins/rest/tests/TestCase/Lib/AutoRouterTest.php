<?php

namespace MixerApi\Rest\Test\TestCase\Lib;

use Cake\TestSuite\TestCase;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use MixerApi\Rest\Lib\AutoRouter;
use ReflectionClass;

class AutoRouterTest extends TestCase
{
    public function testBuildResources()
    {
        $routes = new RouteBuilder(Router::getRouteCollection(),'/');
        $routes->setRouteClass(DashedRoute::class);
        $routes->scope('/', function (RouteBuilder $builder) {
            $builder->fallbacks();
            (new AutoRouter($builder, 'MixerApi\Rest\Test\App\Controller'))->buildResources();
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