<?php

namespace MixerApi\CollectionView\Test\TestCase;

use Cake\Controller\Controller;
use Cake\Http\ServerRequestFactory;
use Cake\TestSuite\TestCase;
use MixerApi\CollectionView\Configuration;
use MixerApi\CollectionView\View\JsonCollectionView;
use MixerApi\CollectionView\View\XmlCollectionView;

class ConfigurationTest extends TestCase
{
    public function test_views(): void
    {
        $controller = new Controller(ServerRequestFactory::fromGlobals());

        $controller = (new Configuration())->views($controller);
        $map = $controller->viewClasses();

        $this->assertEquals(JsonCollectionView::class, $map[0]);
        $this->assertEquals(XmlCollectionView::class, $map[1]);
    }

    public function test_views_with_no_request_handler(): void
    {
        $controller = new Controller(ServerRequestFactory::fromGlobals());
        $this->assertTrue(!isset($controller->RequestHandler));
    }
}
