<?php
declare(strict_types=1);

namespace MixerApi\Crud\Test\App\Controller;

use Cake\Controller\Controller;
use Cake\View\JsonView;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
    }

    public function viewClasses(): array
    {
        return [JsonView::class];
    }
}
