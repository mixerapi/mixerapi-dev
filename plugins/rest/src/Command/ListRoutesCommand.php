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
    /**
     * @param \Cake\Console\ConsoleOptionParser $parser ConsoleOptionParser
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser
            ->setDescription('Lists your applications RESTful routes');

        if (defined('TEST_APP')) {
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
            $io->out('<warning> > No routes were found</warning>');
            $io->out('<warning> > Do you have any routes defined in `config/routes.php`?</warning>');
            $io->out();
            $this->abort();
        }

        (new RouteTable($io, $args, $routes))->output();
    }
}
