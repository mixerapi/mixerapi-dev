<?php

namespace MixerApi\Crud\Test\TestCase;

use Cake\Http\Exception\BadRequestException;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use MixerApi\Crud\Deserializer;

class DeserializerTest extends TestCase
{
    public function test_xml(): void
    {
        $request =
            (new ServerRequest([
                'input' => '<?xml version="1.0" encoding="UTF-8" standalone="no" ?><Actor><hi>hi</hi></Actor>',
            ]))->withHeader('Content-type', 'application/xml');

        $this->assertIsArray((new Deserializer())->deserialize($request));
    }

    public function test_bad_request_exception(): void
    {
        $this->expectException(BadRequestException::class);

        $request =
            (new ServerRequest([
                'input' => '<?xml version="1.0" encoding="UTF-8" standalone="no" ?><Actor></Actor>',
            ]))->withHeader('Content-type', 'application/xml');

        (new Deserializer())->deserialize($request);
    }
}
