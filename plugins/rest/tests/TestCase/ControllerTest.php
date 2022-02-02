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

    public function test_index_is_http_200(): void
    {
        $this->get('/actors.json');
        $this->assertResponseOk();
    }

    public function test_view_is_http_200(): void
    {
        $this->get('/actors/1.json');
        $this->assertResponseOk();
    }

    public function test_add_is_http_201(): void
    {
        $this->post('/actors.json', [
            'last_name' => 'ever',
            'first_name' => 'greatest'
        ]);
        $this->assertResponseCode(201);
    }

    public function test_edit_is_http_200(): void
    {
        $this->patch('/actors/1.json', [
            'last_name' => 'ever',
            'first_name' => 'greatest'
        ]);
        $this->assertResponseCode(200);
    }

    public function test_delete_is_http_204(): void
    {
        $this->delete('/actors/1.json');
        $this->assertResponseCode(204);
    }
}
