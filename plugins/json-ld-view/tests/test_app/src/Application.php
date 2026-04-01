<?php
declare(strict_types=1);

namespace MixerApi\JsonLdView\Test\App;

use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Routing\RouteBuilder;

class Application extends BaseApplication
{
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        return $middlewareQueue->add(new RoutingMiddleware($this))->add(new BodyParserMiddleware());
    }

    public function bootstrap(): void
    {
        $this->addPlugin('MixerApi/JsonLdView');
    }

    public function routes(RouteBuilder $routes): void
    {
        $routes->scope('/', function (RouteBuilder $builder) {
            $builder->fallbacks();
            $builder->setExtensions(['jsonld']);
            $builder->connect('/contexts/*', [
                'plugin' => 'MixerApi/JsonLdView' ,'controller' => 'JsonLd', 'action' => 'contexts'
            ]);
            $builder->connect('/vocab', [
                'plugin' => 'MixerApi/JsonLdView' ,'controller' => 'JsonLd', 'action' => 'vocab'
            ]);
        });
        parent::routes($routes);
    }
}
