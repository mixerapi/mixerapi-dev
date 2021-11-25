<?php
declare(strict_types=1);

namespace MixerApi\Rest\Lib\Route;

use Cake\Routing\Route\Route;
use MixerApi\Rest\Lib\Exception\RestfulRouteException;

/**
 * RouteDecorator decorates the CakePHP Route class to provide meta-data on the route such as its Controller, action
 * method, etc... in an object-oriented way. This is an improvement on the key-value Route::defaults that CakePHP uses.
 */
class RouteDecorator
{
    /**
     * @var \Cake\Routing\Route\Route The CakePHP Route that is being decorated.
     */
    private Route $route;

    /**
     * @var string|null The Route name as given by CakePHP Route.
     */
    private ?string $name;

    /**
     * @var string|null The Plugin a Route is associated with.
     */
    private ?string $plugin;

    /**
     * @var string|null The Controller a Route is associated with.
     */
    private ?string $controller;

    /**
     * @var string|null The Controller Action (method) the route calls.
     */
    private ?string $action;

    /**
     * @var string[] An array of HTTP Methods (e.g. POST, PATCH, GET)
     */
    private array $methods = [];

    /**
     * @var string|null The Route template
     */
    private ?string $template;

    /**
     * @param \Cake\Routing\Route\Route $route A CakePHP Route that will be decorated.
     */
    public function __construct(Route $route)
    {
        $defaults = (array)$route->defaults;

        $methods = $defaults['_method'];
        if (is_string($defaults['_method'])) {
            $methods = explode(', ', $defaults['_method']);
        }

        if (empty($methods)) {
            throw new RestfulRouteException(
                'Cannot create RESTful route `' . $route->template . '` with empty HTTP Methods'
            );
        }

        $this
            ->setTemplate($route->template)
            ->setName($route->getName())
            ->setPlugin($defaults['plugin'])
            ->setController($defaults['controller'])
            ->setAction($defaults['action'])
            ->setMethods($methods)
            ->setRoute($route);
    }

    /**
     * @return \Cake\Routing\Route\Route
     */
    public function getRoute(): Route
    {
        return $this->route;
    }

    /**
     * @param \Cake\Routing\Route\Route $route CakePHP Route
     * @return \MixerApi\Rest\Lib\Route\RouteDecorator
     */
    public function setRoute(Route $route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name Route name (e.g. controller:index)
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlugin(): ?string
    {
        return $this->plugin;
    }

    /**
     * @param string|null $plugin Plugin name
     * @return $this
     */
    public function setPlugin(?string $plugin)
    {
        $this->plugin = $plugin;

        return $this;
    }

    /**
     * @return string
     */
    public function getController(): ?string
    {
        return $this->controller;
    }

    /**
     * @param string $controller Controller name without Controller (e.g. Actors, not ActorsController)
     * @return $this
     */
    public function setController(string $controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * @return string
     */
    public function getAction(): ?string
    {
        return $this->action;
    }

    /**
     * @param string $action The controller method (e.g. index, view, edit, delete, add)
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return string[] An array of HTTP methods (e.g. PUT, POST, PATCH, GET, DELETE)
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @param string[] $methods HTTP methods (e.g. PUT, POST, PATCH, GET, DELETE)
     * @return $this
     */
    public function setMethods(array $methods)
    {
        $this->methods = array_map('strtoupper', $methods);

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate(): ?string
    {
        return $this->template;
    }

    /**
     * @param string $template Uri Template (e.g. controller/action)
     * @return $this
     */
    public function setTemplate(string $template)
    {
        $this->template = $template;

        return $this;
    }
}
