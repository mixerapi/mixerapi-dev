<?php

namespace MixerApi\Crud\Test\TestCase\Exception;

use Cake\TestSuite\TestCase;
use MixerApi\Crud\Test\App\Model\Entity\Actor;
use MixerApi\Crud\Exception\ResourceWriteException;

class ResourceWriteExceptionTest extends TestCase
{
    public function test()
    {
        $this->assertInstanceOf(Actor::class, (new ResourceWriteException(new Actor()))->getEntity());
    }
}
