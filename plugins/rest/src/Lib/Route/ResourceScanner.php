<?php
declare(strict_types=1);

namespace MixerApi\Rest\Lib\Route;

use Cake\Core\Configure;
use MixerApi\Rest\Lib\Controller\ControllerUtility;

/**
 * ResourceScanner is used to get an array of ReflectedControllerDecorator by scanning a namespace for all controllers
 * within it.
 */
class ResourceScanner
{
    /**
     * @param string|null $namespace A namespace (e.g. App or App\Controller\Sub) that will be scanned for
     * CakePHP Controllers. If none is defined then the `App.namespace` setting from your `config/app.php` is used.
     */
    public function __construct(private ?string $namespace = null)
    {
        $this->namespace = $namespace ?? Configure::read('App.namespace') . '\Controller';
    }

    /**
     * Returns an array of ReflectedControllerDecorator by scanning `$this->namespace`.
     *
     * @return \MixerApi\Rest\Lib\Controller\ReflectedControllerDecorator[]
     * @throws \ReflectionException
     */
    public function getControllerDecorators(): array
    {
        $controllers = ControllerUtility::getControllersFqn($this->namespace);
        $controllerDecorators = ControllerUtility::getReflectedControllerDecorators($controllers);

        return array_values(array_filter($controllerDecorators, function ($controller) {
            return $controller->hasCrud();
        }));
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }
}
