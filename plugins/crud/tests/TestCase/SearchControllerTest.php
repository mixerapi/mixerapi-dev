<?php

namespace MixerApi\Crud\Test\TestCase;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class SearchControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @var string[]
     */
    public $fixtures = [
        'plugin.MixerApi/Crud.Films',
    ];

    public function setUp(): void
    {
        parent::setUp();
        static::setAppNamespace('MixerApi\Crud\Test\App');
    }

    public function test_index()
    {
        $this->get('/films.json');
        $this->assertResponseOk();

        $body = (string)$this->_response->getBody();
        $array = json_decode($body, true);
        $this->assertNotEmpty($array);
    }
}
