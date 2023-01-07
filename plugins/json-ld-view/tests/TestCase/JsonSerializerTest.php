<?php

namespace MixerApi\JsonLdView\Test\TestCase;

use Cake\Datasource\FactoryLocator;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use Cake\View\Helper\PaginatorHelper;
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
    public $fixtures = [
        'plugin.MixerApi/JsonLdView.Actors',
        'plugin.MixerApi/JsonLdView.FilmActors',
        'plugin.MixerApi/JsonLdView.Films',
    ];

    /**
     * @var ServerRequest
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

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
     * Test collection serialization and deserialization
     */
    public function test_collection(): void
    {
        $actor = FactoryLocator::get('Table')->get('Actors');
        $result = $actor->find()->contain('Films')->limit(1)->all();

        $paginator = new PaginatorHelper(
            new JsonLdView($this->request, $this->response),
            ['templates' => 'MixerApi/JsonLdView.paginator-template']
        );
        $paginator->defaultModel('Actor');

        $jsonSerializer = new JsonSerializer($result, $this->request, $paginator);

        $json = $jsonSerializer->asJson(JSON_PRETTY_PRINT);

        $this->assertIsString($json);
        $this->assertIsObject(json_decode($json));
    }

    /**
     * Test item serialization and deserialization
     */
    public function test_item(): void
    {
        $actor = FactoryLocator::get('Table')->get('Actors');
        $result = $actor->get(1, [
            'contain' => 'Films'
        ]);

        $paginator = new PaginatorHelper(
            new JsonLdView($this->request, $this->response),
            ['templates' => 'MixerApi/JsonLdView.paginator-template']
        );
        $paginator->defaultModel('Actor');

        $jsonSerializer = new JsonSerializer($result, $this->request, $paginator);

        $json = $jsonSerializer->asJson(JSON_PRETTY_PRINT);

        $this->assertIsString($json);
        $this->assertIsObject(json_decode($json));
    }

    /**
     * Test JsonSerializer->getData()
     */
    public function test_get_data(): void
    {
        $actor = FactoryLocator::get('Table')->get('Actors');
        $result = $actor->find()->contain('Films')->limit(1)->all();

        $paginator = new PaginatorHelper(
            new JsonLdView($this->request, $this->response),
            ['templates' => 'MixerApi/JsonLdView.paginator-template']
        );
        $paginator->defaultModel('Actor');

        $jsonSerializer = new JsonSerializer($result, $this->request, $paginator);

        $this->assertIsArray($jsonSerializer->getData());
    }

    public function test_get_data_with_query_param(): void
    {
        $actor = FactoryLocator::get('Table')->get('Actors');
        $result = $actor->find()->contain('Films')->limit(1)->all();
        $request = $this->createRequest([
            'url' => $url = '/?test=test&hello=world',
            'query' => ['test' => 'test', 'hello' => 'world']
        ]);

        $paginator = new PaginatorHelper(
            new JsonLdView($request, $this->response),
            ['templates' => 'MixerApi/JsonLdView.paginator-template']
        );
        $paginator->defaultModel('Actor');

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
