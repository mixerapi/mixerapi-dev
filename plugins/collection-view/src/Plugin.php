<?php
declare(strict_types=1);

namespace MixerApi\CollectionView;

use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\PluginApplicationInterface;
use Cake\Event\Event;
use Cake\Event\EventManager;

class Plugin extends BasePlugin
{
    /**
     * @param \Cake\Core\PluginApplicationInterface $app PluginApplicationInterface
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        parent::bootstrap($app);

        try {
            Configure::load('collection_view');
        } catch (\Exception $e) {
        }

        $configuration = new Configuration();

        if (Configure::read('CollectionView') === null) {
            $configuration->default();
        }

        EventManager::instance()
            ->on('Controller.initialize', function (Event $event) use ($configuration) {

                /** @var \Cake\Controller\Controller $controller */
                $controller = $event->getSubject();
                $configuration->views($controller);
            });

        (new SwaggerBakeExtension())->listen();
    }
}
