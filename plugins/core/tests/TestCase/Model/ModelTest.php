<?php

namespace MixerApi\Core\Test\TestCase\Model;

use Cake\Datasource\ConnectionManager;
use Cake\Datasource\SchemaInterface;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\TestSuite\TestCase;
use Cake\Validation\ValidationSet;
use MixerApi\Core\Model\Model;
use MixerApi\Core\Model\ModelFactory;
use MixerApi\Core\Model\ModelProperty;

class ModelTest extends TestCase
{
    /**
     * @var string[]
     */
    public $fixtures = [
        'plugin.MixerApi/Core.Actors',
    ];

    public function testModel()
    {
        $model = (new ModelFactory(
            ConnectionManager::get('default'),
            new \MixerApi\Core\Test\App\Model\Table\ActorsTable()
        ))->create();

        $this->assertInstanceOf(Model::class, $model);
        $this->assertInstanceOf(Entity::class, $model->getEntity());
        $this->assertInstanceOf(SchemaInterface::class, $model->getSchema());
        $this->assertInstanceOf(Table::class, $model->getTable());
        $this->assertNotEmpty($model->getProperties());
        $this->assertInstanceOf(ModelProperty::class, $model->getProperty('first_name'));
    }

    public function testModelProperty()
    {
        $model = (new ModelFactory(
            ConnectionManager::get('default'),
            new \MixerApi\Core\Test\App\Model\Table\ActorsTable()
        ))->create();

        $this->assertTrue($model->getProperty('id')->isPrimaryKey());
        $this->assertEmpty($model->getProperty('first_name')->getDefault());
        $this->assertEquals('string', $model->getProperty('first_name')->getType());
        $this->assertEquals('first_name', $model->getProperty('first_name')->getName());
        $this->assertInstanceOf(ValidationSet::class, $model->getProperty('first_name')->getValidationSet());

        $this->expectException(\InvalidArgumentException::class);
        $model->getProperty('does_not_exist');
    }
}
