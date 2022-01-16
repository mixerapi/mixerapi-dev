<?php
declare(strict_types=1);

namespace MixerApi\Rest\Lib\Route;

use MixerApi\Rest\Lib\Controller\ReflectedControllerDecorator;
use MixerApi\Rest\Lib\Exception\RestfulRouteException;

/**
 * RouteDecoratorFactory is used to create many CakePHP Routes and then decorate them as RouteDecorator.
 */
class RouteDecoratorFactory
{
    /**
     * @param string $namespace A namespace (e.g. App\Controller) that will be scanned for Routes.
     * @param string|null $plugin An optional Plugin name
     */
    public function __construct(
        private string $namespace,
        private ?string $plugin = null
    ) {
    }

    /**
     * Creates a RouteDecorator instance from a ReflectedControllerDecorator instance
     *
     * @param \MixerApi\Rest\Lib\Controller\ReflectedControllerDecorator $controller ReflectedControllerDecorator
     * @return \MixerApi\Rest\Lib\Route\RouteDecorator[]
     */
    public function createFromReflectedControllerDecorator(ReflectedControllerDecorator $controller): array
    {
        $routeDecorators = [];

        if (!$controller->hasCrud()) {
            return $routeDecorators;
        }

        foreach ($controller->getMethods() as $action) {
            try {
                $route = RouteFactory::create(
                    $this->namespace,
                    $controller,
                    $action->getName(),
                    $this->plugin
                );

                $routeDecorators[] = new RouteDecorator($route);
            } catch (RestfulRouteException $e) {
            }
        }

        return $routeDecorators;
    }
}
