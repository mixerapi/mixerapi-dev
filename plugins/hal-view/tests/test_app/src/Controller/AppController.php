<?php
declare(strict_types=1);

namespace MixerApi\HalView\Test\App\Controller;

use Cake\Controller\Controller;
use MixerApi\HalView\View\HalJsonView;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
    }

    public function viewClasses(): array
    {
        return ['haljson' => HalJsonView::class];
    }
}
