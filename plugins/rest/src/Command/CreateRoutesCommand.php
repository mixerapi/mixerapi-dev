<?php
declare(strict_types=1);

namespace MixerApi\Rest\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use Cake\Utility\Inflector;
use MixerApi\Rest\Lib\Controller\ControllerUtility;
use MixerApi\Rest\Lib\Route\ResourceScanner;
use MixerApi\Rest\Lib\Route\RouteDecoratorFactory;
use MixerApi\Rest\Lib\Route\RouteWriter;

/**
 * Class RouteCommand
 *
 * @package SwaggerBake\Command
 */
class CreateRoutesCommand extends Command
{
    /**
     * @param \Cake\Console\ConsoleOptionParser $parser ConsoleOptionParser
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser
            ->setDescription('Creates RESTful routes')
            ->addOption('display', [
                'help' => 'Display what routes will be created only, will not write to files',
            ])
            ->addOption('plugin', [
                'help' => 'Specify a plugin (e.g. MyPlugin)',
            ])
            ->addOption('namespace', [
                'help' => 'A base namespace (e.g. App\Controller or App\Api\Controller)',
            ])
            ->addOption('prefix', [
                'help' => 'Route prefix (e.g. /api)',
            ]);

        if (defined('IS_TEST')) {
            $parser->addOption('routesFile', [
                'help' => 'Specifies a name for the routes file, for testing only',
            ]);
            $parser->addOption('configPath', [
                'help' => 'Specifies config path directory, for testing only',
            ]);
        }

        return $parser;
    }

    /**
     * List Cake Routes that can be added to Swagger. Prints to console.
     *
     * @param \Cake\Console\Arguments $args Arguments
     * @param \Cake\Console\ConsoleIo $io ConsoleIo
     * @return int|void|null
     * @throws \ReflectionException
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $io->hr();
        $io->out('| Creating routes ');
        $io->hr();

        if ($args->getOption('plugin')) {
            $namespace = $args->getOption('namespace') ?? $args->getOption('plugin');
            $prefix = $args->getOption('prefix') ?? '/' . Inflector::dasherize($args->getOption('plugin'));
        } else {
            $namespace = Configure::read('App.namespace');
            $prefix = '/';
        }

        $configDir = $this->whichConfig($args);
        $namespace = $args->getOption('namespace') ?? $namespace . '\Controller';
        $prefix = $args->getOption('prefix') ?? $prefix;

        $controllers = (new ResourceScanner($namespace))->getControllerDecorators();

        if (empty($controllers)) {
            $io->warning("> No controllers were found in namespace `$namespace`");
            $this->abort();
        }

        if ($args->getOption('display') === null) {
            $file = $args->getOption('routesFile') ?? 'routes.php';

            $ask = $io->ask('This will modify`' . $configDir . $file . '`, continue?', 'Y');
            if (strtoupper($ask) !== 'Y') {
                $this->abort();
            }

            (new RouteWriter($controllers, $namespace, $configDir, $prefix, $args->getOption('plugin')))
                ->merge($file);
            $io->success('> Routes were written to ' . $configDir . $file);
            $io->out();

            return;
        }

        $controllers = $plugin ?? ControllerUtility::getControllersFqn($namespace);

        $decoratedControllers = ControllerUtility::getReflectedControllerDecorators($controllers);

        $routeDecorators = [];

        $factory = new RouteDecoratorFactory($namespace, $prefix, $args->getOption('plugin'));
        foreach ($decoratedControllers as $decorator) {
            $routeDecorators = array_merge(
                $routeDecorators,
                $factory->createFromReflectedControllerDecorator($decorator)
            );
        }

        (new RouteTable($io, $args, $routeDecorators))->output();
    }

    /**
     * Returns directory path to config
     *
     * @param \Cake\Console\Arguments $args Arguments
     * @return string
     * @throws \RuntimeException
     */
    private function whichConfig(Arguments $args): string
    {
        if ($args->getOption('configPath')) {
            return $args->getOption('configPath');
        }
        if ($args->getOption('plugin')) {
            $plugins = Configure::read('App.paths.plugins');

            return $configDir = reset($plugins) . $args->getOption('plugin') . DS . 'config' . DS;
        }

        if (!defined('CONFIG')) {
            throw new \RunTimeException('Unable to locate config path');
        }

        return CONFIG;
    }
}
