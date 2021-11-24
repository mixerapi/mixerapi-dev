<?php
declare(strict_types=1);

namespace MixerApi\Rest\Lib;

use Cake\Routing\RouteBuilder;
use MixerApi\Rest\Lib\Route\ResourceScanner;

/**
 * Builds RESTful CRUD route resources.
 */
class AutoRouter
{
    /**
     * @param \Cake\Routing\RouteBuilder $builder CakePHP RouteBuilder
     * @param \MixerApi\Rest\Lib\Route\ResourceScanner|null $scanner An instance of ResourceScanner, if none is
     * supplied a scanner will be created.
     */
    public function __construct(
        private ?RouteBuilder $builder,
        private ?ResourceScanner $scanner = null,
    ) {
        $this->scanner = $this->scanner ?? new ResourceScanner();
    }

    /**
     * Builds RESTful resources for controllers found by ResourceScanner.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function buildResources(): void
    {
        foreach ($this->scanner->getControllerDecorators() as $decorator) {
            $routeNames = $decorator->findCrudRoutes();
            if (empty($routeNames)) {
                continue;
            }

            $paths = $decorator->getPaths($this->scanner->getNamespace());
            if (empty($paths)) {
                $this->builder->resources($decorator->getResourceName(), [
                    'only' => $routeNames,
                ]);
                continue;
            }

            $this->builder->resources($decorator->getResourceName(), [
                'path' => $decorator->getPathTemplate($this->scanner->getNamespace()),
                'prefix' => end($paths),
                'only' => $routeNames,
            ]);
        }
    }
}
