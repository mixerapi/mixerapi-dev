<?php

namespace MixerApi\ExceptionRender\Test\TestCase;

use Cake\TestSuite\TestCase;
use MixerApi\ExceptionRender\MixerApiExceptionRenderer;
use MixerApi\ExceptionRender\ValidationException;

class MixerApiExceptionRenderTest extends TestCase
{
    public function test_get_error()
    {
        $this->assertInstanceOf(
            ValidationException::class,
            (new MixerApiExceptionRenderer(new ValidationException()))->getError()
        );
    }
}
