<?php
declare(strict_types=1);

namespace MixerApi\CollectionView\Test\App\Controller;

use Cake\Controller\Controller;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }
}
