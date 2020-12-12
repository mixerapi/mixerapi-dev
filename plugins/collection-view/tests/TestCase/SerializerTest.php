<?php

namespace MixerApi\CollectionView\Test\TestCase;

use Cake\Datasource\FactoryLocator;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use Cake\View\Helper\PaginatorHelper;
use MixerApi\CollectionView\Configuration;
use MixerApi\CollectionView\View\JsonCollectionView;
use MixerApi\CollectionView\Serializer;
use SimpleXMLElement;

class SerializerTest extends TestCase
{
    /**
     * @var string[]
     */
    public $fixtures = [
        'plugin.MixerApi/CollectionView.Actors',
    ];

    public function setUp(): void
    {
        parent::setUp();
        (new Configuration())->default();
    }

    public function testAsJson()
    {
        $actor = FactoryLocator::get('Table')->get('Actors');
        $result = $actor->find()->limit(1)->all();

        $request = (new ServerRequest())->withEnv('HTTP_ACCEPT', 'application/json');

        $paginator = new PaginatorHelper(
            new JsonCollectionView($request, new Response()),
            ['templates' => 'MixerApi/CollectionView.paginator-template']
        );
        $paginator->defaultModel('Actor');

        $jsonSerializer = new Serializer($result, $request, $paginator);

        $json = $jsonSerializer->asJson(JSON_PRETTY_PRINT);
        $this->assertIsString($json);

        $obj = json_decode($json);
        $this->assertIsObject($obj);
        $this->assertEquals('/', $obj->collection->url);
        $this->assertCount(1, $obj->data);
    }

    public function testAsXml()
    {
        $actor = FactoryLocator::get('Table')->get('Actors');
        $result = $actor->find()->limit(1)->all();

        $request = (new ServerRequest())->withEnv('HTTP_ACCEPT', 'application/json');

        $paginator = new PaginatorHelper(
            new JsonCollectionView($request, new Response()),
            ['templates' => 'MixerApi/CollectionView.paginator-template']
        );
        $paginator->defaultModel('Actor');

        $jsonSerializer = new Serializer($result, $request, $paginator);

        $xml = $jsonSerializer->asXml(['pretty' => true]);
        $this->assertIsString($xml);

        $simpleXml = simplexml_load_string($xml);
        $this->assertInstanceOf(SimpleXMLElement::class, $simpleXml);
        $this->assertEquals('/', $simpleXml->collection->url);
        $this->assertInstanceOf(SimpleXMLElement::class, $simpleXml->data);
    }
}