<?php
declare(strict_types=1);

namespace MixerApi\Rest\Lib\Controller;

use Cake\Controller\Controller;
use Cake\Utility\Text;
use MixerApi\Rest\Lib\Exception\InvalidControllerException;
use MixerApi\Rest\Lib\Exception\RunTimeException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Decorates an instance of a CakePHP Controller
 */
class ReflectedControllerDecorator
{
    private ReflectionClass $reflectedController;

    /**
     * Can be instantiated with a fully qualified namespace or ReflectionClass instance
     *
     * @param mixed $controller FQN or ReflectionClass
     * @throws \ReflectionException
     * @throws \MixerApi\Rest\Lib\Exception\RunTimeException
     * @throws \MixerApi\Rest\Lib\Exception\InvalidControllerException
     */
    public function __construct(mixed $controller)
    {
        if (is_string($controller)) {
            try {
                $this->reflectedController = new ReflectionClass($controller);
            } catch (ReflectionException $e) {
                throw new RunTimeException(
                    "Unable to create ReflectionClass using `$controller`. Maybe check your namespace? " .
                    'ReflectionException: ' . $e->getMessage()
                );
            }
        } elseif ($controller instanceof ReflectionClass) {
            $this->reflectedController = $controller;
        }

        if (!$this->reflectedController->isSubclassOf(Controller::class)) {
            throw new InvalidControllerException(
                sprintf(
                    'Controller `%s` must be a subclass of Controller',
                    $this->getReflectedController()->getShortName()
                )
            );
        }
    }

    /**
     * Returns an array of namespaces for the controller, for example given App\Controller for a controller located at
     * App\Controller\SubResource\ActorsController, the output would be: ['SubResource']
     *
     * @param string $baseNamespace the base namespace (e.g. App\Controller)
     * @return string[]
     */
    public function getPaths(string $baseNamespace): array
    {
        $namespace = $this->getReflectedController()->getName();
        $relativeNs = str_replace($baseNamespace . '\\', '', $namespace);

        $paths = explode('\\', $relativeNs);

        if (empty($paths)) {
            return [];
        }

        array_pop($paths);

        if (empty($paths)) {
            return [];
        }

        return $paths;
    }

    /**
     * Gets a template path from namespace, for example given App\Controller for a controller located at
     * App\Controller\SubResource\ActorsController, the output would be: `sub-resource/actors`
     *
     * @param string $baseNamespace a base name space (e.g. App or App\Controller\Sub)
     * @return string
     */
    public function getPathTemplate(string $baseNamespace): string
    {
        $paths = array_map(
            function ($item) {
                return Text::slug(strtolower($item));
            },
            $this->getPaths($baseNamespace)
        );

        return implode('/', $paths) . '/' . Text::slug(strtolower($this->getResourceName()));
    }

    /**
     * Does the controller have a CRUD method: index, view, add, update, and delete
     *
     * @return bool
     */
    public function hasCrud(): bool
    {
        $crud = ['index','view','add','edit','delete'];
        $result = array_filter($this->getMethods(), function (ReflectionMethod $reflectionMethod) use ($crud) {
            return in_array($reflectionMethod->getName(), $crud);
        });

        return count($result) > 0;
    }

    /**
     * Returns a list of CRUD routes
     *
     * @return string[]
     */
    public function findCrudRoutes(): array
    {
        $return = [];

        $actionRoutes = [
            'index' => 'index',
            'view' => 'view',
            'add' => 'create',
            'edit' => 'update',
            'delete' => 'delete',
        ];

        $result = array_filter(
            $this->getMethods(),
            function (ReflectionMethod $reflectionMethod) use ($actionRoutes) {
                return array_key_exists($reflectionMethod->getName(), $actionRoutes);
            }
        );

        $actions = array_column($result, 'name');
        foreach ($actionRoutes as $action => $route) {
            if (in_array($action, $actions)) {
                $return[] = $route;
            }
        }

        return $return;
    }

    /**
     * Gets a Controllers methods as an array of ReflectionMethod instances
     *
     * @return \ReflectionMethod[]
     * @throws \MixerApi\Rest\Lib\Exception\RunTimeException
     */
    public function getMethods(): array
    {
        try {
            return array_filter(
                $this->reflectedController->getMethods(ReflectionMethod::IS_PUBLIC),
                function ($method) {
                    return $method->class == $this->reflectedController->getName();
                }
            );
        } catch (\Exception $e) {
            throw new RunTimeException($e->getMessage());
        }
    }

    /**
     * @return \ReflectionClass
     */
    public function getReflectedController(): ReflectionClass
    {
        return $this->reflectedController;
    }

    /**
     * Returns the CakePHP controller as a resource name, suitable for route resources
     *
     * @return string
     */
    public function getResourceName(): string
    {
        $shortName = $this->getReflectedController()->getShortName();

        return str_replace('Controller', '', $shortName);
    }
}
