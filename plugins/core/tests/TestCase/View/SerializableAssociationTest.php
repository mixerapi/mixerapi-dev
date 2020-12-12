<?php

namespace MixerApi\Core\Test\TestCase\View;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;
use Cake\TestSuite\TestCase;
use MixerApi\Core\View\SerializableAssociation;

class SerializableAssociationTest extends TestCase
{
    public function testGetSerializableProperties()
    {
        $entity = new Entity([
            'id' => 1,
            'name' => 'Andrew',
            'friends' => [new Entity(['name' => 'Brittany'])],
            'job' => new Entity(['title' => 'Developer', 'organization' => 'Acme']),
            '_joinData' => []
        ]);

        $this->assertCount(2, (new SerializableAssociation($entity))->getAssociations());
    }

    public function testGetSerializablePropertiesNoResults()
    {
        $entity = new Entity([
            'id' => 1,
            'name' => 'Andrew',
            'created' => new FrozenTime(),
            '_joinData' => []
        ]);

        $this->assertCount(0, (new SerializableAssociation($entity))->getAssociations());
    }
}