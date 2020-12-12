<?php

namespace MixerApi\ExceptionRender\Test\TestCase;

use Cake\TestSuite\TestCase;
use MixerApi\ExceptionRender\EntityValidationListener;
use MixerApi\ExceptionRender\ValidationException;
use TestApp\Model\Entity\Actor;
use TestApp\Model\Table\ActorsTable;

class EntityValidationTest extends TestCase
{
    /**
     * @var string[]
     */
    public $fixtures = [
        'plugin.MixerApi/ExceptionRender.Actors',
    ];

    public function testValidation()
    {
        new EntityValidationListener();

        $actorsTable = new ActorsTable();
        $actor = $actorsTable->patchEntity($actorsTable->newEmptyEntity(), [
            'first_name' => 'First',
            'last_name' => 'last'
        ]);

        $this->assertInstanceOf(Actor::class, $actor);
    }

    public function testValidationException()
    {
        $this->expectException(ValidationException::class);

        new EntityValidationListener();

        $actorsTable = new ActorsTable();
        $actorsTable->patchEntity($actorsTable->newEmptyEntity(), [
            'first_name' => '',
            'last_name' => ''
        ]);
    }
}