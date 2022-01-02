<?php

namespace MixerApi\ExceptionRender\Test\TestCase;

use Cake\TestSuite\TestCase;
use MixerApi\ExceptionRender\OpenApiExceptionSchema;

class OpenApiExceptionSchemaTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals(422, OpenApiExceptionSchema::getExceptionCode());
        $this->assertEquals(null, OpenApiExceptionSchema::getExceptionDescription());

        $schema = OpenApiExceptionSchema::getExceptionSchema();
        $this->assertArrayHasKey('exception', $schema->getProperties());
        $this->assertArrayHasKey('message', $schema->getProperties());
        $this->assertArrayHasKey('url', $schema->getProperties());
        $this->assertArrayHasKey('code', $schema->getProperties());
        $this->assertArrayHasKey('violations', $schema->getProperties());
    }
}
