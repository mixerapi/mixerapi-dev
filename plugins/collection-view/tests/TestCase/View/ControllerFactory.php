<?php

namespace MixerApi\CollectionView\Test\TestCase\View;

use Cake\Controller\Component\PaginatorComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Datasource\FactoryLocator;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;

class ControllerFactory
{
    /**
     * Builds a controller for actors/index requests
     *
     * @return Controller
     */
    public function build(): Controller
    {
        $request = new ServerRequest([
            'url' => 'actors',
            'params' => [
                'plugin' => null,
                'controller' => 'Actors',
                'action' => 'index',
            ]
        ]);
        $request = $request->withEnv('HTTP_ACCEPT', 'application/json, text/plain, */*');
        Router::setRequest($request);

        $controller = new Controller($request, new Response(), 'Actors');
        $controller->modelClass = 'Actors';
        $registry = new ComponentRegistry($controller);

        $paginator = new PaginatorComponent($registry);

        $actorTable = FactoryLocator::get('Table')->get('Actors');
        $actors = $paginator->paginate($actorTable, [
            'contain' => ['Films'],
            'limit' => 2
        ]);

        $controller->set([
            'actors' => $actors,
        ]);

        return $controller;
    }
}
