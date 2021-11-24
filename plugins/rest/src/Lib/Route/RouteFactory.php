<?php
declare(strict_types=1);

namespace MixerApi\Rest\Lib\Route;

use Cake\Routing\Route\Route;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use MixerApi\Rest\Lib\Controller\ReflectedControllerDecorator;
use MixerApi\Rest\Lib\Exception\RestfulRouteException;

/**
 * RouteFactory creates a CakePHP route from a Controller. This is used by AutoRouter to create routes at run-time.
 *
 * @uses \Cake\Utility\Inflector
 * @uses \Cake\Utility\Text
 */
class RouteFactory
{
    private const ACTION_HTTP_METHODS = [
        'index' => 'GET',
        'add' => 'POST',
        'view' => 'GET',
        'edit' => ['PATCH','PUT'],
        'delete' => 'DELETE',
    ];

    /**
     * @param string $namespace A base namespace (e.g. App\Controller) that the Controller exists in. This is used to
     * set the Route::template and Route::defaults['prefix']
     * @param \MixerApi\Rest\Lib\Controller\ReflectedControllerDecorator $controller An instance of
     * ReflectedControllerDecorator. This is used to set the Controller the Route will call.
     * @param string $action The Controller Action (method) that the Route will call.
     * @param string|null $plugin An optional Plugin that the route can exist in.
     * @return \Cake\Routing\Route\Route
     * @throws \MixerApi\Rest\Lib\Exception\RestfulRouteException
     */
    public static function create(
        string $namespace,
        ReflectedControllerDecorator $controller,
        string $action,
        ?string $plugin = null
    ): Route {
        if (!isset(self::ACTION_HTTP_METHODS[$action])) {
            throw new RestfulRouteException("Action `$action` is unknown. This route will not be created");
        }

        $template = Text::slug(strtolower($controller->getResourceName()));

        $defaults = [
            '_method' => self::ACTION_HTTP_METHODS[$action],
            'action' => $action,
            'controller' => $controller->getResourceName(),
            'plugin' => $plugin ?? null,
        ];

        $nsPaths = $controller->getPaths($namespace);

        if (!empty($nsPaths)) {
            $paths = array_map(function ($path) {
                return Inflector::dasherize($path);
            }, $nsPaths);

            $template = implode('/', $paths) . '/';
            $template .= Text::slug(strtolower($controller->getResourceName()));
            $defaults['prefix'] = implode('/', $nsPaths);
        }

        $template .= "/$action";

        if (in_array($action, ['add','view','update','delete'])) {
            $template .= '/:id';
        }

        return new Route($template, $defaults);
    }
}
