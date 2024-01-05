<?php
declare(strict_types=1);

namespace MixerApi\CollectionView\Test\App\Controller;

use Cake\Controller\Controller;
use Cake\View\XmlView;
use MixerApi\CollectionView\View\JsonCollectionView;
use MixerApi\CollectionView\View\XmlCollectionView;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
    }

    public function viewClasses(): array
    {
        return [JsonCollectionView::class,  XmlCollectionView::class];
    }
}
