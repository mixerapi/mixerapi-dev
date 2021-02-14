<?php

namespace MixerApi\ExceptionRender\Test\TestCase;

use Cake\Core\Configure;
use Cake\Collection\Collection;
use Cake\TestSuite\TestCase;
use Cake\TestSuite\IntegrationTestTrait;

class ControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @var string[]
     */
    public $fixtures = [
        'plugin.MixerApi/ExceptionRender.Actors',
    ];

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        static::setAppNamespace('MixerApi\ExceptionRender\Test\App');
    }

    public function testValidationException()
    {
        Configure::write('Error', [
            'errorLevel' => E_ALL,
            'exceptionRenderer' => \MixerApi\ExceptionRender\MixerApiExceptionRenderer::class,
            'skipLog' => [],
            'log' => true,
            'trace' => true,
        ]);


        $this->post('/actors.json', [
            'first_name' => '',
            'last_name' => '',
        ]);

        $this->assertEquals(422, $this->_response->getStatusCode());

        $body = (string)$this->_response->getBody();
        $object = json_decode($body);
        $this->assertEquals('ValidationException', $object->exception);
        $this->assertEquals('Error saving resource `Actor`', $object->message);
        $this->assertEquals(422, $object->code);
        $this->assertCount(2, $object->violations);

        $violation = (new Collection($object->violations))
            ->filter(function($violation){
                return $violation->propertyPath == 'first_name';
            })
            ->first();
        $this->assertIsObject($violation);
        $this->assertCount(1, $violation->messages);

        $message = reset($violation->messages);
        $this->assertEquals('_empty', $message->rule);
        $this->assertEquals('This field cannot be left empty', $message->message);
    }
}
