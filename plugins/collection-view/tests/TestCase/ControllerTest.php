<?php

namespace MixerApi\CollectionView\Test\TestCase;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class ControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @inheritdoc
     */
    public array $fixtures = [
        'plugin.MixerApi/CollectionView.Actors',
        'plugin.MixerApi/CollectionView.FilmActors',
        'plugin.MixerApi/CollectionView.Films',
    ];

    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        parent::setUp();
        static::setAppNamespace('MixerApi\CollectionView\Test\App');
    }

    public function test_json(): void
    {
        $this->get('/actors.json?limit=1');
        $body = (string)$this->_response->getBody();
        $object = json_decode($body);

        $this->assertResponseOk();
        $this->assertTrue(isset($object->collection->url));
        $this->assertStringNotContainsString('&amp;', $object->collection->next);
        $this->assertNotEmpty($object->data);
    }

    public function test_xml(): void
    {
        $this->get('/actors.xml');
        $body = (string)$this->_response->getBody();
        $object = simplexml_load_string($body);

        $this->assertResponseOk();
        $this->assertTrue(isset($object->collection->url));
        $this->assertNotEmpty($object->data);
    }
}
