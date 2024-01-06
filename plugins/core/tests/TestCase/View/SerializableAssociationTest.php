<?php

namespace MixerApi\Core\Test\TestCase\View;

use Cake\ORM\Entity;
use Cake\TestSuite\TestCase;
use Cake\I18n\DateTime;
use MixerApi\Core\View\SerializableAssociation;

class SerializableAssociationTest extends TestCase
{
    public function test_get_serializable_properties(): void
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

    public function test_get_serializable_properties_no_results(): void
    {
        $entity = new Entity([
            'id' => 1,
            'name' => 'Andrew',
            'created' => new DateTime(),
            '_joinData' => []
        ]);

        $this->assertCount(0, (new SerializableAssociation($entity))->getAssociations());
    }
}
