<?php
declare(strict_types=1);

namespace MixerApi\Rest\Lib\Controller;

use Cake\Cache\Engine\NullEngine;
use Cake\Core\Configure;
use MixerApi\Rest\Lib\Exception\InvalidControllerException;
use Mouf\Composer\ClassNameMapper;
use TheCodingMachine\ClassExplorer\Glob\GlobClassExplorer;

/**
 * Utilities for working with CakePHP controllers.
 *
 * @uses \Cake\Cache\Engine\NullEngine
 * @uses \Cake\Core\Configure
 * @uses \TheCodingMachine\ClassExplorer\Glob\GlobClassExplorer
 */
class ControllerUtility
{
    /**
     * Gets array of controllers fully qualified namespace as strings for the given namespace, defaults to
     * APP.namespace if no argument is given
     *
     * @param string|null $namespace Fully qualified namespace
     * @return string[]
     * @throws \Exception
     */
    public static function getControllersFqn(?string $namespace): array
    {
        $namespace = $namespace ?? Configure::read('App.namespace') . '\Controller';

        $classNameMapper = ClassNameMapper::createFromComposerFile(null, null, true);
        $explorer = new GlobClassExplorer($namespace, new NullEngine(), 0, $classNameMapper);

        return array_keys($explorer->getClassMap());
    }

    /**
     * Gets an array of ReflectedControllerDecorators
     *
     * @param string[] $controllers an array of controllers as fully qualified name space strings
     * @return \MixerApi\Rest\Lib\Controller\ReflectedControllerDecorator[]
     * @throws \ReflectionException
     */
    public static function getReflectedControllerDecorators(array $controllers): array
    {
        $return = [];

        foreach ($controllers as $controllerFqn) {
            try {
                $reflectedControllerDecorator = new ReflectedControllerDecorator($controllerFqn);
                $return[$reflectedControllerDecorator->getResourceName()] = $reflectedControllerDecorator;
            } catch (InvalidControllerException $e) {
                // maybe do something here?
            }
        }

        ksort($return);

        return array_values($return);
    }
}
