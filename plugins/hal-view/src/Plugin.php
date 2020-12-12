<?php
declare(strict_types=1);

namespace MixerApi\HalView;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use MixerApi\Core\Response\ResponseModifier;

class Plugin extends BasePlugin
{
    /**
     * @var string
     */
    private const EXT = 'haljson';

    /**
     * @var string[]
     */
    private const MIME_TYPES = ['application/hal+json','application/vnd.hal+json'];

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
        (new ResponseModifier(self::EXT, self::MIME_TYPES, self::VIEW_CLASS))->listen();
    }
}
