<?php

namespace MixerApi\JsonLdView\Test\TestCase;

use Cake\TestSuite\TestCase;
use MixerApi\JsonLdView\JsonLdSchema;

class JsonLdSchemaTest extends TestCase
{
    public function test_jsonld_schema()
    {
        $property = 'test';
        $url = 'http://schema.org/test';
        $desc = 'hi';
        $jsonLdSchema = (new JsonLdSchema())->setProperty($property)->setSchemaUrl($url)->setDescription($desc);
        $this->assertEquals($property, $jsonLdSchema->getProperty());
        $this->assertEquals($url, $jsonLdSchema->getSchemaUrl());
        $this->assertEquals($desc, $jsonLdSchema->getDescription());
    }

    public function test_set_schema_url_exception()
    {
        $this->expectException(\InvalidArgumentException::class);
        (new JsonLdSchema())->setSchemaUrl('');
    }
}
