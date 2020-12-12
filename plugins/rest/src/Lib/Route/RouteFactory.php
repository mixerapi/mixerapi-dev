<?php
declare(strict_types=1);

namespace MixerApi\Rest\Lib\Route;

use Cake\Routing\Route\Route;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use MixerApi\Rest\Lib\Controller\ReflectedControllerDecorator;
use MixerApi\Rest\Lib\Exception\RestfulRouteException;

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
     * Creates an instance of a CakePHP Route
     *
     * @param string $baseNamespace a base namespace (e.g. App\Controller)
     * @param string $basePath a base path (e.g. `/`)
     * @param \MixerApi\Rest\Lib\Controller\ReflectedControllerDecorator $controller ReflectedControllerDecorator
     * @param string $action Action method
     * @param string|null $plugin Plugin name
     * @return \Cake\Routing\Route\Route
     * @throws \MixerApi\Rest\Lib\Exception\RestfulRouteException
     */
    public static function create(
        string $baseNamespace,
        string $basePath,
        ReflectedControllerDecorator $controller,
        string $action,
        ?string $plugin = null
    ): Route {
        if (!isset(self::ACTION_HTTP_METHODS[$action])) {
            throw new RestfulRouteException("Action `$action` is unknown. This route will not be created");
        }

        $basePath = $basePath . '@todo'; // @todo

        $template = Text::slug(strtolower($controller->getResourceName()));

        $defaults = [
            '_method' => self::ACTION_HTTP_METHODS[$action],
            'action' => $action,
            'controller' => $controller->getResourceName(),
            'plugin' => $plugin ?? null,
        ];

        $nsPaths = $controller->getPaths($baseNamespace);

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
