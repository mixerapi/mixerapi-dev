<?php
declare(strict_types=1);

namespace MixerApi\Core\Utility;

use Cake\Cache\Engine\NullEngine;
use Cake\Collection\Collection;
use Cake\Core\Configure;
use Mouf\Composer\ClassNameMapper;
use RuntimeException;
use TheCodingMachine\ClassExplorer\Glob\GlobClassExplorer;

/**
 * Namespace Utilities
 *
 * @uses \Mouf\Composer\ClassNameMapper
 * @uses \TheCodingMachine\ClassExplorer\Glob\GlobClassExplorer
 */
class NamespaceUtility
{
    /**
     * Finds classes using the $namespace argument and returns an array of namespaces as strings
     *
     * @param string|null $namespace A namespace such as `App\Controller`
     * @return string[]
     */
    public static function findClasses(?string $namespace = null): array
    {
        $namespace = $namespace ?? Configure::read('App.namespace');

        $classNameMapper = ClassNameMapper::createFromComposerFile(null, null, true);
        $explorer = new GlobClassExplorer($namespace, new NullEngine(), 0, $classNameMapper);

        return array_keys($explorer->getClassMap());
    }

    /**
     * Performs a non-recursive search for the classes shortname in the given namespace
     *
     * @param string $namespace The namespace to search in
     * @param string $shortName The short name of the class
     * @return string
     * @throws \RuntimeException
     */
    public static function findClass(string $namespace, string $shortName): string
    {
        $classes = NamespaceUtility::findClasses($namespace);

        $results = (new Collection($classes))->filter(function ($class) use ($shortName) {
            $pieces = explode('\\', $class);

            return end($pieces) == $shortName;
        });

        if (!$results->count()) {
            throw new RuntimeException("Class not found for `$shortName` in `$namespace`");
        }

        return $results->first();
    }
}
