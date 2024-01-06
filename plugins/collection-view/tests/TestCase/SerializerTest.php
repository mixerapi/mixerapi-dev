<?php

namespace MixerApi\CollectionView\Test\TestCase;

use Cake\Datasource\FactoryLocator;
use Cake\Datasource\Paging\PaginatedResultSet;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\ORM\ResultSet;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use Cake\View\Helper\PaginatorHelper;
use MixerApi\CollectionView\Configuration;
use MixerApi\CollectionView\View\JsonCollectionView;
use MixerApi\CollectionView\Serializer;
use MixerApi\CollectionView\View\XmlCollectionView;
use SimpleXMLElement;

class SerializerTest extends TestCase
{
    /**
     * @var string[]
     */
    public array $fixtures = [
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

        Router::createRouteBuilder('/')->scope('/', function (RouteBuilder $builder) {
            $builder->setExtensions(['json']);
            $builder->connect('/', ['controller' => 'Actors', 'action' => 'index']);
            $builder->connect('/{controller}/{action}/*');
            $builder->connect('/{plugin}/{controller}/{action}/*');
        });
        Router::setRequest($request);

        $paginatedResult = new PaginatedResultSet($result, [
            'alias' => 'Actors',
            'currentPage' => 1,
            'count' => 9,
            'totalCount' => 62,
            'hasPrevPage' => false,
            'hasNextPage' => true,
            'pageCount' => 7,
        ]);

        $paginator = new PaginatorHelper(
            new JsonCollectionView(
                $request,
                null,
                null,
                [
                    'viewVars' => [
                        'actors' => $paginatedResult
                    ]
                ]
            ),
            ['templates' => 'MixerApi/CollectionView.paginator-template']
        );

        $jsonSerializer = new Serializer($paginatedResult, $request, $paginator);

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

        Router::createRouteBuilder('/')->scope('/', function (RouteBuilder $builder) {
            $builder->setExtensions(['json']);
            $builder->connect('/', ['controller' => 'Actors', 'action' => 'index']);
            $builder->connect('/{controller}/{action}/*');
            $builder->connect('/{plugin}/{controller}/{action}/*');
        });
        Router::setRequest($request);

        $paginatedResult = new PaginatedResultSet($result, [
            'alias' => 'Actors',
            'currentPage' => 1,
            'count' => 9,
            'totalCount' => 62,
            'hasPrevPage' => false,
            'hasNextPage' => true,
            'pageCount' => 7,
        ]);

        $paginator = new PaginatorHelper(
            new XmlCollectionView(
                $request,
                null,
                null,
                [
                    'viewVars' => [
                        'actors' => $paginatedResult
                    ]
                ]
            ),
            ['templates' => 'MixerApi/CollectionView.paginator-template']
        );

        $jsonSerializer = new Serializer($paginatedResult, $request, $paginator);

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
