<?php

namespace MixerApi\ExceptionRender\Test\TestCase;

use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use MixerApi\ExceptionRender\SerializableException;

class SerializableExceptionTest extends TestCase
{
    public function test_is_throwable(): void
    {
        $wrapped = new \RuntimeException('test');
        $exception = new SerializableException($wrapped);

        $this->assertInstanceOf(\Throwable::class, $exception);
    }

    public function test_is_json_serializable(): void
    {
        $wrapped = new \RuntimeException('test');
        $exception = new SerializableException($wrapped);

        $this->assertInstanceOf(\JsonSerializable::class, $exception);
    }

    public function test_proxies_message_and_code(): void
    {
        $wrapped = new \RuntimeException('Connection refused', 111);
        $exception = new SerializableException($wrapped);

        $this->assertEquals('Connection refused', $exception->getMessage());
        $this->assertEquals(111, $exception->getCode());
    }

    public function test_proxies_file_and_line(): void
    {
        $wrapped = new \RuntimeException('test');
        $exception = new SerializableException($wrapped);

        $this->assertEquals($wrapped->getFile(), $exception->getFile());
        $this->assertEquals($wrapped->getLine(), $exception->getLine());
    }

    public function test_json_serialize_returns_structured_data(): void
    {
        $wrapped = new \RuntimeException('Connection refused', 111);
        $exception = new SerializableException($wrapped);

        Configure::write('debug', true);
        $data = $exception->jsonSerialize();

        $this->assertEquals('RuntimeException', $data['class']);
        $this->assertEquals('Connection refused', $data['message']);
        $this->assertEquals(111, $data['code']);
        $this->assertArrayHasKey('file', $data);
        $this->assertArrayHasKey('line', $data);
    }

    public function test_json_serialize_excludes_file_and_line_without_debug(): void
    {
        $wrapped = new \RuntimeException('Connection refused', 111);
        $exception = new SerializableException($wrapped);

        Configure::write('debug', false);
        $data = $exception->jsonSerialize();

        $this->assertEquals('RuntimeException', $data['class']);
        $this->assertEquals('Connection refused', $data['message']);
        $this->assertEquals(111, $data['code']);
        $this->assertArrayNotHasKey('file', $data);
        $this->assertArrayNotHasKey('line', $data);

        Configure::write('debug', true);
    }

    public function test_json_encode_produces_correct_output(): void
    {
        $wrapped = new \RuntimeException('test', 42);
        $exception = new SerializableException($wrapped);

        Configure::write('debug', false);
        $json = json_encode($exception);
        $decoded = json_decode($json, true);

        $this->assertEquals('RuntimeException', $decoded['class']);
        $this->assertEquals('test', $decoded['message']);
        $this->assertEquals(42, $decoded['code']);

        Configure::write('debug', true);
    }
}
