<?php

namespace MixerApi\ExceptionRender\Test\TestCase;

use Cake\TestSuite\TestCase;
use MixerApi\ExceptionRender\ErrorDecorator;

class ErrorDecoratorTest extends TestCase
{
    public function test_error_decorator(): void
    {
        $decorator = new ErrorDecorator([], []);
        $decorator->setViewVars($viewVars = ['1']);
        $decorator->setSerialize($serialize = ['1','2']);
        $this->assertEquals($viewVars, $decorator->getViewVars());
        $this->assertEquals($serialize, $decorator->getSerialize());
    }
}
