<?php

namespace MixerApi\Rest\Test\TestCase\Lib\Controller;

use Cake\TestSuite\TestCase;
use MixerApi\Rest\Lib\Controller\ReflectedControllerDecorator;
use MixerApi\Rest\Lib\Exception\RunTimeException;

class ReflectedControllerDecoratorTest extends TestCase
{
    public function testConstruct()
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

    public function testConstructException()
    {
        $this->expectException(RunTimeException::class);
        $decorator = new ReflectedControllerDecorator(
            'MixerApi\Rest\Test\Nope'
        );
    }
}