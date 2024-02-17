<?php

namespace MixerApi\JsonLdView\Test\TestCase\Controller;

use Cake\TestSuite\TestCase;
use Cake\TestSuite\IntegrationTestTrait;

class JsonLdControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @var string[]
     */
    public array $fixtures = [
        'plugin.MixerApi/JsonLdView.Actors',
        'plugin.MixerApi/JsonLdView.Addresses',
        'plugin.MixerApi/JsonLdView.FilmActors',
        'plugin.MixerApi/JsonLdView.Films',
    ];

    public function setUp(): void
    {
        parent::setUp();
        static::setAppNamespace('MixerApi\JsonLdView\Test\App');
    }

    /**
     * When `/contexts/{tableAlias}` is called, the schema for the table is returned in `application/ld+json` format.
     *
     * @dataProvider dataProviderForTestContext
     */
    public function test_context(string $tableAlias): void
    {
        $this->get('/contexts/' . $tableAlias);

        $body = (string)$this->_response->getBody();
        $object = json_decode($body);

        $this->assertResponseOk();
        $this->assertEquals('application/ld+json', $this->_response->getHeaderLine('content-type'));
        $this->assertEquals('https://schema.org/givenName', $object->{'@context'}->first_name);
        $this->assertEquals('https://schema.org/familyName', $object->{'@context'}->last_name);
        $this->assertEquals('https://schema.org/identifier', $object->{'@context'}->id);
        $this->assertEquals('https://schema.org/DateTime', $object->{'@context'}->modified);
        $this->assertEquals('https://schema.org/Text', $object->{'@context'}->write);
        $this->assertEquals('https://schema.org/Text', $object->{'@context'}->read);
        $this->assertEquals('https://schema.org/Text', $object->{'@context'}->hide);
    }

    public static function dataProviderForTestContext(): array
    {
        return [
            ['Actors'],
            ['actors'],
        ];
    }

    /**
     * @todo: Assertions below are skipped because the namespace utility is ignoring classes in Test namespaces
     */
    public function test_vocab(): void
    {
        $this->get('/vocab');
        $this->assertResponseOk();
        $this->assertEquals('application/ld+json', $this->_response->getHeaderLine('content-type'));
        $this->markTestIncomplete();
        /*
        $body = (string)$this->_response->getBody();
        $object = json_decode($body);
        $this->assertCount(3, $object->{'supportedClass'});
        $results = array_filter((array) $object->{'supportedClass'}, function (\stdClass $obj) {
            return in_array($obj->title, ['Actor', 'Address', 'Film']);
        });
        $this->assertCount(3, $results);
        */
    }
}
