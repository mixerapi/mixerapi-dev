<?php
declare(strict_types=1);

namespace MixerApi\Rest\Lib\Route;

use Cake\Routing\Route\Route;
use Cake\Routing\Router;

/**
 * Class RouteScanner
 *
 * Scans for routes
 *
 * @package MixerApi\Rest\Lib
 */
class RouteScanner
{
    /**
     * @var string[]
     */
    private const EXCLUDED_PLUGINS = [
        'DebugKit',
        'SwaggerBake',
    ];

    /**
     * @var \Cake\Routing\Router
     */
    private $router;

    /**
     * @param \Cake\Routing\Router $router CakePHP Router instance
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Gets an array of RouteDecorator instances
     *
     * @return \MixerApi\Rest\Lib\Route\RouteDecorator[]
     */
    public function getDecoratedRoutes(): array
    {
        $routes = array_filter($this->router::routes(), function ($route) {
            return $this->isRouteAllowed($route);
        });

        $decoratedRoutes = [];

        foreach ($routes as $route) {
            $decoratedRoutes[$route->getName()] = new RouteDecorator($route);
        }

        ksort($decoratedRoutes);

        return $decoratedRoutes;
    }

    /**
     * Returns boolean indicating if a route is allowed
     *
     * @param \Cake\Routing\Route\Route $route CakePHP Route instance
     * @return bool
     */
    private function isRouteAllowed(Route $route): bool
    {
        $defaults = (array)$route->defaults;

        if (!isset($defaults['_method']) || empty($defaults['_method'])) {
            return false;
        }

        if (isset($defaults['plugin']) && in_array($defaults['plugin'], self::EXCLUDED_PLUGINS)) {
            return false;
        }

        return true;
    }
}
