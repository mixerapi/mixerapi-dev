<?php
declare(strict_types=1);

namespace MixerApi\Bake;

use Cake\Core\BasePlugin;
use Cake\Core\Plugin as CakePlugin;
use Cake\Core\PluginApplicationInterface;
use Cake\Event\EventInterface;
use Cake\Event\EventManager;

class Plugin extends BasePlugin
{
    /**
     * @inheritDoc
     */
    protected ?string $name = 'MixerApi/Bake';

    /**
     * @inheritDoc
     */
    protected bool $consoleEnabled = false;

    /**
     * @inheritDoc
     */
    protected bool $middlewareEnabled = false;

    /**
     * @inheritDoc
     */
    protected bool $servicesEnabled = false;

    /**
     * @inheritDoc
     */
    protected bool $routesEnabled = false;

    /**
     * @param \Cake\Core\PluginApplicationInterface $app PluginApplicationInterface
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        parent::bootstrap($app);

        EventManager::instance()->on('Bake.beforeRender', function (EventInterface $event) {
            $view = $event->getSubject();
            $view->set('plugins', CakePlugin::loaded());
        });
    }
}
