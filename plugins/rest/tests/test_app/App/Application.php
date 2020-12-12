<?php
declare(strict_types=1);

namespace MixerApi\Rest\Test\App;

use Cake\Console\CommandCollection;
use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;
use Bake\Command\EntryCommand;
use Cake\Routing\RouteBuilder;

class Application extends BaseApplication
{
    public function middleware(MiddlewareQueue $middleware): MiddlewareQueue
    {
        return $middleware;
    }

    public function bootstrap(): void
    {
        $this->addPlugin('MixerApi/Rest');

    }

    /**
     * @param CommandCollection $commands
     * @return CommandCollection
     */
    public function console(CommandCollection $commands): CommandCollection
    {
        return $commands;
    }

    public function routes(RouteBuilder $routes): void
    {
        $routes->scope('/', function (RouteBuilder $builder) {
            $builder->fallbacks();
            $builder->setExtensions(['json']);
            $builder->resources('Actors');
        });
        parent::routes($routes);
    }
}
