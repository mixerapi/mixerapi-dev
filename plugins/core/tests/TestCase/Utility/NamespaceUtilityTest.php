<?php

namespace MixerApi\Core\Test\TestCase\Utility;

use Cake\TestSuite\TestCase;
use MixerApi\Core\Utility\NamespaceUtility;

class NamespaceUtilityTest extends TestCase
{
    public function testFindClasses()
    {
        $this->assertNotEmpty(NamespaceUtility::findClasses('MixerApi\Core\Test\App'));
    }

    public function testFindClass()
    {
        $this->assertNotEmpty(NamespaceUtility::findClass('MixerApi\Core\Test\App\Model\Entity', 'Actor'));
    }

    public function testFindClassWithException()
    {
        $this->expectException(\RuntimeException::class);
        $this->assertNotEmpty(NamespaceUtility::findClass('MixerApi\Core\Test\App\Model\Entity', 'Nope'));
    }
}
