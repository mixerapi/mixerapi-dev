<?php

namespace MixerApi\CollectionView\Test\TestCase\View;

use Cake\Controller\Component\PaginatorComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Datasource\Paging\NumericPaginator;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Routing\Router;

class ControllerFactory
{
    use LocatorAwareTrait;

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
        $controller->set('modelClass', 'Actors');
        echo '<pre>' . __FILE__ . ':' . __LINE__;
        print_r($controller);
        echo '</pre>';
        die();

        //$controller->modelClass = 'Actors';
        //$registry = new ComponentRegistry($controller);

        //$paginator = new PaginatorComponent($registry);
        $paginator = new NumericPaginator();

        $query = $this->getTableLocator()->get('Actors')->find()->contain(['Films']);
        $actors = $paginator->paginate($query);

        $controller->set([
            'actors' => $actors,
        ]);

        return $controller;
    }
}
