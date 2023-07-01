<?php

namespace MixerApi\CollectionView\Test\TestCase;

use Cake\Controller\Controller;
use Cake\Http\ServerRequestFactory;
use Cake\TestSuite\TestCase;
use MixerApi\CollectionView\Configuration;

class ConfigurationTest extends TestCase
{
    public function test_views(): void
    {
        $controller = new Controller(ServerRequestFactory::fromGlobals());
        $controller->loadComponent('RequestHandler');

        $controller = (new Configuration())->views($controller);
        $map = $controller->RequestHandler->getConfig('viewClassMap');
        $this->assertEquals('MixerApi/CollectionView.JsonCollection', $map['json']);
        $this->assertEquals('MixerApi/CollectionView.XmlCollection', $map['xml']);
    }

    public function test_views_with_no_request_handler(): void
    {
        $controller = new Controller(ServerRequestFactory::fromGlobals());
        $this->assertTrue(!isset($controller->RequestHandler));
    }
}
