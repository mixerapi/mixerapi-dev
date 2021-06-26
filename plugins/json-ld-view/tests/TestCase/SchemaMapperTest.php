<?php

namespace MixerApi\JsonLdView\Test\TestCase;

use Cake\Datasource\ConnectionManager;
use Cake\TestSuite\TestCase;
use MixerApi\Core\Model\ModelFactory;
use MixerApi\JsonLdView\SchemaMapper;

class SchemaMapperTest extends TestCase
{
    public function test_schema_mapper()
    {
        $model = (new ModelFactory(
            ConnectionManager::get('default'),
            new \MixerApi\JsonLdView\Test\App\Model\Table\FilmsTable()
        ))->create();

        $schemaUrl = SchemaMapper::findSchemaFromModelProperty($model->getProperty('id'));
        $this->assertEquals('https://schema.org/identifier', $schemaUrl);

        $schemaUrl = SchemaMapper::findSchemaFromModelProperty($model->getProperty('title'));
        $this->assertEquals('https://schema.org/Text', $schemaUrl);

        $schemaUrl = SchemaMapper::findSchemaFromModelProperty($model->getProperty('length'));
        $this->assertEquals('https://schema.org/CreditCard', $schemaUrl);

        $schemaUrl = SchemaMapper::findSchemaFromModelProperty($model->getProperty('modified'));
        $this->assertEquals('https://schema.org/DateTime', $schemaUrl);
    }
}
