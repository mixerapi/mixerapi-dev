<?php
declare(strict_types=1);

namespace MixerApi\Rest\Lib\Route;

use MixerApi\Rest\Lib\Exception\RouteScopeNotFound;
use MixerApi\Rest\Lib\Exception\RunTimeException;
use MixerApi\Rest\Lib\Parser\RouteScopeFinder;
use MixerApi\Rest\Lib\Parser\RouteScopeModifier;
use PhpParser\Node;
use PhpParser\NodeFinder;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;

/**
 * Class RouteWriter
 *
 * Writes routes to `config/routes.php`
 *
 * @package MixerApi\Rest\Lib\Route
 */
class RouteWriter
{
    /**
     * @var \MixerApi\Rest\Lib\Controller\ReflectedControllerDecorator[]
     */
    private $resources;

    /**
     * @var string
     */
    private $baseNamespace;

    /**
     * @var string
     */
    private $configDir;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var string
     */
    private $plugin;

    /**
     * @param \MixerApi\Rest\Lib\Controller\ReflectedControllerDecorator[] $resources ReflectedControllerDecorator[]
     * @param string $baseNamespace a base namespace
     * @param string $configDir an absolute directory path to userland CakePHP config
     * @param string $prefix route prefix (e.g `/`)
     * @param string $plugin route prefix (e.g `/`)
     */
    public function __construct(
        array $resources,
        string $baseNamespace,
        string $configDir,
        string $prefix,
        ?string $plugin = null
    ) {
        if (!is_dir($configDir)) {
            throw new RunTimeException("Directory does not exist `$configDir`");
        }

        $this->resources = $resources;
        $this->baseNamespace = $baseNamespace;
        $this->configDir = $configDir;
        $this->prefix = $prefix;
        $this->plugin = $plugin;
    }

    /**
     * Merges routes into an existing scope in routes.php
     *
     * @param string $file the routes.php file (mainly used for unit testing)
     * @return void
     */
    public function merge(string $file = 'routes.php'): void
    {
        $routesFile = $this->configDir . $file;

        if (!is_file($routesFile)) {
            throw new RunTimeException('Routes file does not exist `' . $routesFile . '`');
        }

        if (!is_writable($routesFile)) {
            throw new RunTimeException('Routes file is not writable `' . $routesFile . '`');
        }

        $contents = file_get_contents($routesFile);
        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
        $ast = $parser->parse($contents);

        $routeScopeFinder = new RouteScopeFinder($this);

        $nodes = (new NodeFinder())->find($ast, function (Node $node) use ($routeScopeFinder) {
            return $routeScopeFinder->finder($node);
        });

        if (empty($nodes)) {
            throw new RouteScopeNotFound(
                'No route scope or route plugin was found for the given arguments. Try adding one to your ' .
                'routes.php before trying again'
            );
        }

        $traverser = new NodeTraverser();
        $traverser->addVisitor(new RouteScopeModifier($this));

        $nodes = $traverser->traverse($ast);

        $code = (new Standard())->prettyPrintFile($nodes);

        file_put_contents($routesFile, $code);
    }

    /**
     * @return \MixerApi\Rest\Lib\Controller\ReflectedControllerDecorator[]
     */
    public function getResources(): array
    {
        return $this->resources;
    }

    /**
     * @return string
     */
    public function getBaseNamespace(): string
    {
        return $this->baseNamespace;
    }

    /**
     * @return string
     */
    public function getConfigDir(): string
    {
        return $this->configDir;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @return string|null
     */
    public function getPlugin(): ?string
    {
        return $this->plugin;
    }
}
