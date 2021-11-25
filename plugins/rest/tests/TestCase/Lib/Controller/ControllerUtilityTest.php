<?php

namespace MixerApi\Rest\Test\TestCase\Lib\Controller;

use Cake\TestSuite\TestCase;
use MixerApi\Rest\Lib\Controller\ControllerUtility;
use MixerApi\Rest\Lib\Exception\RunTimeException;

class ControllerUtilityTest extends TestCase
{
    public function test_get_controllers_fqn(): void
    {
        $this->assertIsArray(ControllerUtility::getControllersFqn('MixerApi\Rest\Test\App'));
    }
}
