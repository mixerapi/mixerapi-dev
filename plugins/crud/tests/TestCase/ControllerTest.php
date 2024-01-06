<?php

namespace MixerApi\Crud\Test\TestCase;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class ControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @var string[]
     */
    public array $fixtures = [
        'plugin.MixerApi/Crud.Actors',
        'plugin.MixerApi/Crud.Films',
    ];

    public function setUp(): void
    {
        parent::setUp();
        static::setAppNamespace('MixerApi\Crud\Test\App');
    }

    public function test_index(): void
    {
        $this->get('/actors.json');
        $this->assertResponseOk();

        $body = (string)$this->_response->getBody();
        $array = json_decode($body, true);
        $this->assertNotEmpty($array);
    }

    public function test_view(): void
    {
        $this->get('/actors/1.json');
        $this->assertResponseOk();

        $body = (string)$this->_response->getBody();
        $object = json_decode($body);
        $this->assertEquals(1, $object->id);
    }

    public function test_add(): void
    {
        $this->configRequest([
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $this->post('/actors.json', json_encode([
            'last_name' => 'ever',
            'first_name' => 'greatest'
        ]));
        $this->assertResponseOk();

        $body = (string)$this->_response->getBody();
        $object = json_decode($body);
        $this->assertEquals('ever', $object->last_name);
    }

    public function test_add_fails(): void
    {
        $this->post('/actors.json', [
            'last_name' => '',
            'first_name' => ''
        ]);
        $this->assertResponseCode(500);
    }

    public function test_edit(): void
    {
        $this->configRequest([
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $this->patch('/actors/1.json', json_encode([
            'last_name' => 'ever',
            'first_name' => 'greatest'
        ]));
        $this->assertResponseOk();

        $body = (string)$this->_response->getBody();
        $object = json_decode($body);
        $this->assertEquals('ever', $object->last_name);
    }

    public function test_edit_fails(): void
    {
        $this->patch('/actors/1.json', [
            'last_name' => '',
            'first_name' => ''
        ]);
        $this->assertResponseCode(500);
    }

    public function test_delete(): void
    {
        $this->delete('/actors/1.json');
        $this->assertResponseCode(204);
    }
}
