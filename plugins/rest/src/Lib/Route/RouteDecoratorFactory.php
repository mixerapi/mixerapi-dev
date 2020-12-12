<?php
declare(strict_types=1);

namespace MixerApi\Rest\Lib\Route;

use MixerApi\Rest\Lib\Controller\ReflectedControllerDecorator;
use MixerApi\Rest\Lib\Exception\RestfulRouteException;

class RouteDecoratorFactory
{
    /**
     * @var string
     */
    private $baseNamespace;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var string
     */
    private $plugin;

    /**
     * @param string $baseNamespace a base namespace (e.g. App\Controller)
     * @param string $prefix a path prefix (e.g. '/' or 'api')
     * @param string|null $plugin Plugin name
     */
    public function __construct(string $baseNamespace, string $prefix, ?string $plugin = null)
    {
        $this->baseNamespace = $baseNamespace;
        $this->prefix = $prefix;
        $this->plugin = $plugin;
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
                    $this->baseNamespace,
                    $this->prefix,
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
