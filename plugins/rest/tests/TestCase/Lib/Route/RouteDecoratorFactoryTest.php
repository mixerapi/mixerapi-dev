<?php

namespace MixerApi\Rest\Test\TestCase\Lib\Route;

use Cake\TestSuite\TestCase;
use MixerApi\Rest\Lib\Controller\ReflectedControllerDecorator;
use MixerApi\Rest\Lib\Route\RouteDecorator;
use MixerApi\Rest\Lib\Route\RouteDecoratorFactory;

class RouteDecoratorFactoryTest extends TestCase
{
    public function test_create_from_reflected_controller_decorator(): void
    {
        $reflectedControllerDecorator = new ReflectedControllerDecorator(
            'MixerApi\Rest\Test\App\Controller\ActorsController'
        );

        $routeDecorators = (new RouteDecoratorFactory('MixerApi\Rest\Test\App\Controller', '/'))
            ->createFromReflectedControllerDecorator($reflectedControllerDecorator);

        $this->assertIsArray($routeDecorators);
        $this->assertInstanceOf(RouteDecorator::class,reset($routeDecorators));
    }
}
