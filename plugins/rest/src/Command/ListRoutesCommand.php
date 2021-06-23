<?php
declare(strict_types=1);

namespace MixerApi\Rest\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Routing\Router;
use MixerApi\Rest\Lib\Route\RouteScanner;

/**
 * Class RouteCommand
 *
 * @package SwaggerBake\Command
 */
class ListRoutesCommand extends Command
{
    public const NO_ROUTES_FOUND = 'No routes were found';

    /**
     * @param \Cake\Console\ConsoleOptionParser $parser ConsoleOptionParser
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser
            ->setDescription('Lists your applications RESTful routes');

        if (defined('IS_TEST')) {
            $parser->addOption('reloadRoutes', [
                'help' => 'Clears runtime routes, for testing only',
            ]);
        }

        $parser->addOption('plugin', [
            'help' => 'Limit displayed routes to a specific plugin or for your main application use `App`',
        ]);

        return $parser;
    }

    /**
     * List Cake Routes that can be added to Swagger. Prints to console.
     *
     * @param \Cake\Console\Arguments $args Arguments
     * @param \Cake\Console\ConsoleIo $io ConsoleIo
     * @return int|void|null
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $io->hr();
        $io->out('| Finding routes...');
        $io->hr();

        $router = new Router();

        if ($args->getOption('reloadRoutes') !== null) {
            $router::reload();
        }

        $routes = (new RouteScanner($router))->getDecoratedRoutes();

        if (empty($routes)) {
            $io->out();
            $io->out('<warning> > ' . self::NO_ROUTES_FOUND . '</warning>');
            $io->out('<warning> > Do you have any routes defined in `config/routes.php`?</warning>');
            $io->out();
            $this->abort();
        }

        (new RouteTable($io, $args, $routes))->output();
    }
}
