<?php

namespace MixerApi\ExceptionRender\Test\TestCase;

use Cake\TestSuite\TestCase;
use MixerApi\ExceptionRender\ValidationException;

class ValidationExceptionTest extends TestCase
{
    public function test_get_errors_returns_empty_array_on_null_entity(): void
    {
        $this->assertCount(0, (new ValidationException())->getErrors());
        $this->assertNull((new ValidationException())->getEntity());
    }
}
