<?php
declare(strict_types=1);

namespace MixerApi\CollectionView;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use MixerApi\CollectionView\View\JsonCollectionView;
use MixerApi\CollectionView\View\XmlCollectionView;

class Configuration
{
    /**
     * Sets a default configuration
     *
     * @return void
     */
    public function default()
    {
        Configure::write('CollectionView', [
            'collection' => '{{collection}}',
            'collection.url' => '{{url}}',
            'collection.count' => '{{count}}',
            'collection.total' => '{{total}}',
            'collection.pages' => '{{pages}}',
            'collection.next' => '{{next}}',
            'collection.prev' => '{{prev}}',
            'collection.first' => '{{first}}',
            'collection.last' => '{{last}}',
            'data' => '{{data}}',
        ]);
    }

    /**
     * Sets request handler views for json and xml
     *
     * @param \Cake\Controller\Controller $controller Controller instance
     * @return \Cake\Controller\Controller
     */
    public function views(Controller $controller): Controller
    {
        $controller->addViewClasses([
                JsonCollectionView::class,
                XmlCollectionView::class,
        ]);

        return $controller;
    }
}
