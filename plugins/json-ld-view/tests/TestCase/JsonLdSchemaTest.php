<?php

namespace MixerApi\JsonLdView\Test\TestCase;

use Cake\TestSuite\TestCase;
use MixerApi\JsonLdView\JsonLdSchema;

class JsonLdSchemaTest extends TestCase
{
    public function testJsonLdSchema()
    {
        $property = 'test';
        $url = 'http://schema.org/test';
        $desc = 'hi';
        $jsonLdSchema = (new JsonLdSchema())->setProperty($property)->setSchemaUrl($url)->setDescription($desc);
        $this->assertEquals($property, $jsonLdSchema->getProperty());
        $this->assertEquals($url, $jsonLdSchema->getSchemaUrl());
        $this->assertEquals($desc, $jsonLdSchema->getDescription());
    }

    public function testSetSchemaUrlException()
    {
        $this->expectException(\InvalidArgumentException::class);
        (new JsonLdSchema())->setSchemaUrl('');
    }
}