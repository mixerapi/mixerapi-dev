<?php

namespace MixerApi\Rest\Test\TestCase\Lib\Controller;

use Cake\TestSuite\TestCase;
use MixerApi\Rest\Lib\Controller\ReflectedControllerDecorator;
use MixerApi\Rest\Lib\Exception\InvalidControllerException;
use MixerApi\Rest\Lib\Exception\RunTimeException;

class ReflectedControllerDecoratorTest extends TestCase
{
    public function test_construct(): void
    {
        $decorator = new ReflectedControllerDecorator(
            'MixerApi\Rest\Test\App\Controller\ActorsController'
        );

        $this->assertInstanceOf(ReflectedControllerDecorator::class, $decorator);

        $decorator = new ReflectedControllerDecorator(
            new \ReflectionClass('MixerApi\Rest\Test\App\Controller\ActorsController')
        );

        $this->assertInstanceOf(ReflectedControllerDecorator::class, $decorator);
    }

    public function test_construct_exception(): void
    {
        $this->expectException(RunTimeException::class);
        new ReflectedControllerDecorator('MixerApi\Rest\Test\Nope');
    }

    public function test_construct_invalid_controller_exception(): void
    {
        $this->expectException(InvalidControllerException::class);
        new ReflectedControllerDecorator('Cake\TestSuite\TestCase');
    }
}
