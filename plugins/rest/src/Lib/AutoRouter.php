<?php
declare(strict_types=1);

namespace MixerApi\Rest\Lib;

use Cake\Core\Configure;
use Cake\Routing\RouteBuilder;
use MixerApi\Rest\Lib\Route\ResourceScanner;

class AutoRouter
{
    /**
     * @param \Cake\Routing\RouteBuilder $builder CakePHP RouteBuilder
     * @param string|null $namespace A namespace to build routes for (e.g. App\Controller)
     */
    public function __construct(
        private RouteBuilder $builder,
        private ?string $namespace = null
    ) {
        $this->namespace = $namespace ?? Configure::read('App.namespace') . '\Controller';
    }

    /**
     * Builds RESTful route resources
     *
     * @return void
     * @throws \ReflectionException
     */
    public function buildResources(): void
    {
        $resources = (new ResourceScanner($this->namespace))->getControllerDecorators();

        foreach ($resources as $resource) {
            $routeNames = $resource->findCrudRoutes();
            if (empty($routeNames)) {
                continue;
            }

            $paths = $resource->getPaths($this->namespace);
            if (empty($paths)) {
                $this->builder->resources($resource->getResourceName(), [
                    'only' => $routeNames,
                ]);
                continue;
            }

            $this->builder->resources($resource->getResourceName(), [
                'path' => $resource->getPathTemplate($this->namespace),
                'prefix' => end($paths),
                'only' => $routeNames,
            ]);
        }
    }
}
