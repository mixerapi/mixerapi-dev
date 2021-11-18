<?php
declare(strict_types=1);

namespace MixerApi\Rest;

use Cake\Console\CommandCollection;
use Cake\Core\BasePlugin;
use MixerApi\Rest\Command as Commands;

/**
 * Class Plugin
 *
 * @package App
 */
class Plugin extends BasePlugin
{
    /**
     * Plugin name.
     *
     * @var string
     */
    protected $name = 'MixerApi/Rest';

    /**
     * Do bootstrapping or not
     *
     * @var bool
     */
    protected $bootstrapEnabled = false;

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
