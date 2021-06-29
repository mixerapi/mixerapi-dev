<?php
declare(strict_types=1);

namespace MixerApi\Rest;

use Cake\Console\CommandCollection;
use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use MixerApi\Rest\Command as Commands;

/**
 * Class Plugin
 *
 * @package App
 */
class Plugin extends BasePlugin
{
    /**
     * Enable middleware
     *
     * @var bool
     */
    protected $middlewareEnabled = false;

    /**
     * Register container services
     *
     * @var bool
     */
    protected $servicesEnabled = false;

    /**
     * Load routes or not
     *
     * @var bool
     */
    protected $routesEnabled = false;

    /**
     * @param \Cake\Core\PluginApplicationInterface $app PluginApplicationInterface
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        parent::bootstrap($app);
    }

    /**
     * @param \Cake\Console\CommandCollection $commands CommandCollection
     * @return \Cake\Console\CommandCollection
     */
    public function console(CommandCollection $commands): CommandCollection
    {
        $commands->add('mixerapi:rest route list', Commands\ListRoutesCommand::class);
        $commands->add('mixerapi:rest route create', Commands\CreateRoutesCommand::class);

        return $commands;
    }
}
