<?php

namespace MixerApi\CollectionView\Test\TestCase;

use Cake\Datasource\FactoryLocator;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;
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

    public function test_as_json(): void
    {
        $actor = FactoryLocator::get('Table')->get('Actors');
        $result = $actor->find()->limit(1)->all();

        $request = (new ServerRequest([
            'url' => '/',
            'params' => [
                'plugin' => null,
                'controller' => 'Actor',
                'action' => 'index',
            ],
        ]))->withEnv('HTTP_ACCEPT', 'application/json');

        $request = $request->withAttribute('paging', [
            'Actor' => [
                'page' => 1,
                'current' => 1,
                'count' => 60,
                'prevPage' => false,
                'nextPage' => true,
                'pageCount' => 1,
                'sort' => null,
                'direction' => null,
                'limit' => null,
                'start' => 1,
                'end' => 3,
            ],
        ]);
        Router::reload();
        Router::connect('/', ['controller' => 'Actors', 'action' => 'index']);
        Router::connect('/:controller/:action/*');
        Router::connect('/:plugin/:controller/:action/*');
        Router::setRequest($request);

        $paginator = new PaginatorHelper(
            new JsonCollectionView($request, new Response()),
            ['templates' => 'MixerApi/CollectionView.paginator-template']
        );
        $paginator->defaultModel('Actor');

        $jsonSerializer = new Serializer($result, $request, $paginator);

        $json = $jsonSerializer->asJson(JSON_PRETTY_PRINT);
        $this->assertIsString($json);
        $this->assertIsArray($jsonSerializer->getData());

        $obj = json_decode($json);
        $this->assertIsObject($obj);
        $this->assertEquals('/', $obj->collection->url);
        $this->assertCount(1, $obj->data);
    }

    public function test_as_xml(): void
    {
        $actor = FactoryLocator::get('Table')->get('Actors');
        $result = $actor->find()->limit(1)->all();

        $request = (new ServerRequest([
            'url' => '/',
            'params' => [
                'plugin' => null,
                'controller' => 'Actor',
                'action' => 'index',
            ],
        ]))->withEnv('HTTP_ACCEPT', 'application/xml');

        $request = $request->withAttribute('paging', [
            'Actor' => [
                'page' => 1,
                'current' => 1,
                'count' => 60,
                'prevPage' => false,
                'nextPage' => true,
                'pageCount' => 1,
                'sort' => null,
                'direction' => null,
                'limit' => null,
                'start' => 1,
                'end' => 3,
            ],
        ]);
        Router::reload();
        Router::connect('/', ['controller' => 'Actors', 'action' => 'index']);
        Router::connect('/:controller/:action/*');
        Router::connect('/:plugin/:controller/:action/*');
        Router::setRequest($request);

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

    public function test_as_json_throws_run_time_exception(): void
    {
        $this->expectException(\RuntimeException::class);
        (new Serializer(NAN))->asJson(0);
    }
}
