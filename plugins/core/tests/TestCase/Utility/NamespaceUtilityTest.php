<?php

namespace MixerApi\Core\Test\TestCase\Utility;

use Cake\TestSuite\TestCase;
use MixerApi\Core\Utility\NamespaceUtility;

class NamespaceUtilityTest extends TestCase
{
    public function test_find_classes(): void
    {
        $this->assertNotEmpty(NamespaceUtility::findClasses('MixerApi\Core\Test\App'));
    }

    public function test_find_class(): void
    {
        $this->assertNotEmpty(NamespaceUtility::findClass('MixerApi\Core\Test\App\Model\Entity', 'Actor'));
    }

    public function test_find_class_with_exception(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->assertNotEmpty(NamespaceUtility::findClass('MixerApi\Core\Test\App\Model\Entity', 'Nope'));
    }
}
