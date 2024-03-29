<?php

namespace MixerApi\JsonLdView\Test\TestCase;

use Cake\Datasource\FactoryLocator;
use Cake\Datasource\Paging\PaginatedResultSet;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\ORM\Table;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use Cake\View\Helper\PaginatorHelper;
use Cake\View\View;
use MixerApi\JsonLdView\JsonSerializer;
use MixerApi\JsonLdView\View\JsonLdView;

class JsonSerializerTest extends TestCase
{
    /**
     * @var string
     */
    private const EXT = 'jsonld';

    /**
     * @var string[]
     */
    private const MIME_TYPES = ['application/ld+json'];

    /**
     * @var string
     */
    private const VIEW_CLASS = 'MixerApi/JsonLdView.JsonLd';

    /**
     * @var string[]
     */
    public array $fixtures = [
        'plugin.MixerApi/JsonLdView.Actors',
        'plugin.MixerApi/JsonLdView.FilmActors',
        'plugin.MixerApi/JsonLdView.Films',
    ];

    private ServerRequest $request;

    private Response $response;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        static::setAppNamespace('MixerApi\JsonLdView\Test\App');
        $this->request = $this->createRequest();
        Router::reload();
        Router::createRouteBuilder('/')->scope('/', function (RouteBuilder $builder) {
            $builder->setExtensions(['json']);
            $builder->connect('/', ['controller' => 'Actors', 'action' => 'index']);
            $builder->connect('/{controller}/{action}/*');
            $builder->connect('/{plugin}/{controller}/{action}/*');
        });
        Router::setRequest($this->request);
        $this->response = new Response();
    }

    /**
     * @dataProvider dataProviderForCollectionTypes
     */
    public function test_collection(string $resultType): void
    {
        /** @var Table $actor */
        $actor = FactoryLocator::get('Table')->get('Actors');
        $result = $actor->find()->contain('Films')->limit(1)->all();

        $request = $this->createRequest(['url' => '/actors',]);
        $resultSet = new PaginatedResultSet($result, [
            'alias' => 'Actors',
            'currentPage' => 1,
            'count' => $result->count(),
            'totalCount' => $result->count(),
            'hasPrevPage' => false,
            'hasNextPage' => true,
            'pageCount' => 1,
            'end' => 1,
            'start' => 1
        ]);
        $paginator = new PaginatorHelper(
            new View($request, null, null, ['viewVars' => ['actors' => $resultSet]])
        );

        if ($resultType === 'PaginatedResultSet') {
            $jsonSerializer = new JsonSerializer($resultSet, $this->request, $paginator);
        } else {
            $jsonSerializer = new JsonSerializer($result, $this->request, $paginator);
        }

        $json = $jsonSerializer->asJson(JSON_PRETTY_PRINT);

        $this->assertIsString($json);
        $this->assertIsObject(json_decode($json));
    }

    public static function dataProviderForCollectionTypes(): array
    {
        return [
            ['PaginatedResultSet'],
            ['ResultSet'],
        ];
    }

    /**
     * Test item serialization and deserialization
     */
    public function test_item(): void
    {
        /** @var Table $actorsTable */
        $actorsTable = FactoryLocator::get('Table')->get('Actors');
        $result = $actorsTable->get(
            primaryKey: 1,
            args: [
                'contain' => 'Films'
            ]
        );

        $jsonSerializer = new JsonSerializer($result, $this->request, null);

        $json = $jsonSerializer->asJson(JSON_PRETTY_PRINT);

        $this->assertIsString($json);
        $this->assertIsObject(json_decode($json));
    }

    /**
     * Test JsonSerializer->getData()
     */
    public function test_get_data(): void
    {
        /** @var Table $actor */
        $actor = FactoryLocator::get('Table')->get('Actors');
        $result = $actor->find()->contain('Films')->limit(1)->all();
        $request = $this->createRequest(['url' => '/actors']);
        $resultSet = new PaginatedResultSet($result, [
            'alias' => 'Actors',
            'currentPage' => 1,
            'count' => $result->count(),
            'totalCount' => $result->count(),
            'hasPrevPage' => false,
            'hasNextPage' => true,
            'pageCount' => 1,
            'end' => 1,
            'start' => 1
        ]);
        $paginator = new PaginatorHelper(
            new View($request, null, null, ['viewVars' => ['actors' => $resultSet]])
        );

        $jsonSerializer = new JsonSerializer($result, $this->request, $paginator);

        $this->assertIsArray($jsonSerializer->getData());
    }

    public function test_get_data_with_query_param(): void
    {
        /** @var Table $actor */
        $actor = FactoryLocator::get('Table')->get('Actors');
        $result = $actor->find()->contain('Films')->limit(1)->all();
        $request = $this->createRequest([
            'url' => $url = '/?test=test&hello=world',
            'query' => ['test' => 'test', 'hello' => 'world']
        ]);

        $resultSet = new PaginatedResultSet($result, [
            'alias' => 'Actors',
            'currentPage' => 1,
            'count' => $result->count(),
            'totalCount' => $result->count(),
            'hasPrevPage' => false,
            'hasNextPage' => true,
            'pageCount' => 1,
            'end' => 1,
            'start' => 1
        ]);
        $paginator = new PaginatorHelper(
            new View($request, null, null, ['viewVars' => ['actors' => $resultSet]])
        );

        $jsonSerializer = new JsonSerializer($result, $request, $paginator);
        $this->assertEquals($url, $jsonSerializer->getData()['view']['@id']);
    }

    public function test_as_json_throws_run_time_exception(): void
    {
        $this->expectException(\RuntimeException::class);
        (new JsonSerializer(NAN))->asJson(0);
    }

    private function createRequest(array $config = []): ServerRequest
    {
        $config = array_merge([
            'url' => '/',
            'params' => [
                'plugin' => null,
                'controller' => 'Actor',
                'action' => 'index',
            ],
        ], $config);

        $request = (new ServerRequest($config))->withEnv('HTTP_ACCEPT', 'application/ld+json');

        return $request->withAttribute('paging', [
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
    }
}
