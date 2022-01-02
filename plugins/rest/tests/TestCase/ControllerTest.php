<?php

namespace MixerApi\Rest\Test\TestCase;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class ControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @var string[]
     */
    public $fixtures = [
        'plugin.MixerApi/Rest.Actors',
    ];

    public function setUp(): void
    {
        parent::setUp();
        static::setAppNamespace('MixerApi\Rest\Test\App');
    }

    public function test_get_is_http_200(): void
    {
        $this->get('/actors.json');
        $this->assertResponseOk();
    }

    public function test_add_is_http_201_response_code(): void
    {
        $this->post('/actors.json', [
            'last_name' => 'ever',
            'first_name' => 'greatest'
        ]);
        $this->assertResponseCode(201);
    }
}
