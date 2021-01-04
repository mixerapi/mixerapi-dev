<?php
declare(strict_types=1);

namespace MixerApi\Rest\Lib;

use Cake\Core\Configure;
use Cake\Routing\RouteBuilder;
use MixerApi\Rest\Lib\Route\ResourceScanner;

class AutoRouter
{
    /**
     * @var \Cake\Routing\RouteBuilder
     */
    private $builder;

    /**
     * @var string|null
     */
    private $namespace;

    /**
     * @param \Cake\Routing\RouteBuilder $builder RouteBuilder
     * @param string|null $namespace a namespace to build routes for (e.g. App\Controller)
     */
    public function __construct(RouteBuilder $builder, ?string $namespace = null)
    {
        $this->builder = $builder;
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
