<?php
declare(strict_types=1);

namespace MixerApi\HalView;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use MixerApi\Core\Response\ResponseModifier;

class Plugin extends BasePlugin
{
    /**
     * Plugin name.
     *
     * @var string
     */
    protected $name = 'MixerApi/HalView';

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

    /**
     * @var string
     */
    private const EXT = 'haljson';

    /**
     * @var string
     */
    private const VIEW_CLASS = 'MixerApi/HalView.HalJson';

    /**
     * @param \Cake\Core\PluginApplicationInterface $app PluginApplicationInterface
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        parent::bootstrap($app);
        (new ResponseModifier(self::EXT, self::VIEW_CLASS))->listen();
    }
}
