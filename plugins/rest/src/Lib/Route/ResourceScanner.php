<?php
declare(strict_types=1);

namespace MixerApi\Rest\Lib\Route;

use Cake\Core\Configure;
use MixerApi\Rest\Lib\Controller\ControllerUtility;

class ResourceScanner
{
    /**
     * @param string|null $baseNamespace a base name space (e.g. App or App\Controller\Sub)
     */
    public function __construct(private ?string $baseNamespace = null)
    {
        $this->baseNamespace = $baseNamespace ?? Configure::read('App.namespace') . '\Controller';
    }

    /**
     * Returns an array of ReflectedControllerDecorator that can be RESTful resources
     *
     * @return \MixerApi\Rest\Lib\Controller\ReflectedControllerDecorator[]
     * @throws \ReflectionException
     */
    public function getControllerDecorators(): array
    {
        $controllers = ControllerUtility::getControllersFqn($this->baseNamespace);
        $controllerDecorators = ControllerUtility::getReflectedControllerDecorators($controllers);

        return array_values(array_filter($controllerDecorators, function ($controller) {
            return $controller->hasCrud();
        }));
    }
}
