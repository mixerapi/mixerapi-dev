<?php
declare(strict_types=1);

namespace MixerApi\Core\Test\App;

use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;

class Application extends BaseApplication
{
    public function middleware(MiddlewareQueue $middleware): MiddlewareQueue
    {
        return $middleware;
    }

    public function bootstrap(): void
    {
        $this->addPlugin('MixerApi/HalView');
    }
}
