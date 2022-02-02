<?php

namespace MixerApi\JsonLdView\Test\TestCase;

use Cake\TestSuite\TestCase;
use MixerApi\JsonLdView\JsonLdSchema;

class JsonLdSchemaTest extends TestCase
{
    public function test_jsonld_schema(): void
    {
        $jsonLdSchema = new JsonLdSchema(
            $property = 'test',
            $url = 'https://schema.org/person',
            $desc = 'hi'
        );
        $this->assertEquals($property, $jsonLdSchema->getProperty());
        $this->assertEquals($url, $jsonLdSchema->getSchemaUrl());
        $this->assertEquals($desc, $jsonLdSchema->getDescription());

        $jsonLdSchema
            ->setProperty($property = 'updated')
            ->setSchemaUrl($url = "https://schema.org/place")
            ->setDescription($desc = "updated desc");
        $this->assertEquals($property, $jsonLdSchema->getProperty());
        $this->assertEquals($url, $jsonLdSchema->getSchemaUrl());
        $this->assertEquals($desc, $jsonLdSchema->getDescription());
    }

    public function test_set_schema_url_exception(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new JsonLdSchema('name', '');
    }
}
