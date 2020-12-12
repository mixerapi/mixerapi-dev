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
     * @var string
     */
    private const EXT = 'jsonld';

    /**
     * @var string[]
     */
    private const MIME_TYPES = ['application/ld+json'];

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

        (new ResponseModifier(self::EXT, self::MIME_TYPES, self::VIEW_CLASS))->listen();
    }
}
