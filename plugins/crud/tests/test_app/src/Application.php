<?php
declare(strict_types=1);

namespace MixerApi\Crud\Test\App;

use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Routing\RouteBuilder;

class Application extends BaseApplication
{
    public function middleware(MiddlewareQueue $middleware): MiddlewareQueue
    {
        return $middleware->add(new RoutingMiddleware($this))->add(new BodyParserMiddleware());
    }

    public function bootstrap(): void
    {
        $this->addPlugin('Search');
        $this->addPlugin('MixerApi/Crud');
    }

    public function routes(RouteBuilder $routes): void
    {
        $routes->scope('/', function (RouteBuilder $builder) {
            $builder->fallbacks();
            $builder->setExtensions(['json']);
            $builder->resources('Actors');
            $builder->resources('Films');
        });
        parent::routes($routes);
    }
}
