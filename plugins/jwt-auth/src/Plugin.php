<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth;

use Cake\Console\CommandCollection;
use Cake\Core\BasePlugin;
use MixerApi\JwtAuth\Command\KeyGenCommand;

/**
 * Plugin for JwtAuth
 */
class Plugin extends BasePlugin
{
    /**
     * Plugin name.
     *
     * @var string
     */
    protected $name = 'MixerApi/JwtAuth';

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
     * @inheritDoc
     */
    public function console(CommandCollection $commands): CommandCollection
    {
        $commands->add('mixerapi:jwtauth keygen', KeyGenCommand::class);

        return $commands;
    }
}
