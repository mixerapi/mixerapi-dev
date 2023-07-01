<?php
declare(strict_types=1);

namespace MixerApi\JsonLdView;

use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\PluginApplicationInterface;
use MixerApi\Core\Response\ResponseModifier;

class Plugin extends BasePlugin
{
    /**
     * Plugin name.
     *
     * @var string
     */
    protected ?string $name = 'MixerApi/JsonLdView';

    /**
     * Console middleware
     *
     * @var bool
     */
    protected bool $consoleEnabled = false;

    /**
     * Enable middleware
     *
     * @var bool
     */
    protected bool $middlewareEnabled = false;

    /**
     * Register container services
     *
     * @var bool
     */
    protected bool $servicesEnabled = false;

    /**
     * Load routes or not
     *
     * @var bool
     */
    protected bool $routesEnabled = false;

    /**
     * @var string
     */
    private const EXT = 'jsonld';

    /**
     * @var string
     */
    private const VIEW_CLASS = 'MixerApi/JsonLdView.JsonLd';

    /**
     * @param \Cake\Core\PluginApplicationInterface $app PluginApplicationInterface
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        parent::bootstrap($app);

        try {
            Configure::load('jsonld_config');
        } catch (\Exception $e) {
        }

        if (Configure::read('JsonLdView') === null) {
            Configure::write('JsonLdView', [
                'isHydra' => false,
                'schemaUrl' => 'http://schema.org',
                'vocabUrl' => '/vocab',
                'title' => 'API Documentation',
                'description' => '',
                'entrypointUrl' => '/',
            ]);
        }

        (new ResponseModifier(self::EXT, self::VIEW_CLASS))->listen();
    }
}
