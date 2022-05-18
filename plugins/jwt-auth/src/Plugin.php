<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth;

use Cake\Core\BasePlugin;

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
     * Console middleware
     *
     * @var bool
     */
    protected $consoleEnabled = false;

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
}
