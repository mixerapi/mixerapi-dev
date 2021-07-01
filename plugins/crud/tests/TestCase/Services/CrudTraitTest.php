<?php

namespace MixerApi\Crud\Test\TestCase\Services;

use Cake\Http\Response;
use Cake\TestSuite\TestCase;
use MixerApi\Crud\Services\Delete;

class CrudTraitTest extends TestCase
{
    public function test_set_table_name()
    {
        $this->assertInstanceOf(Delete::class, (new Delete())->setTableName('name'));
    }

    public function test_set_allow_methods()
    {
        $this->assertInstanceOf(Delete::class, (new Delete())->setAllowMethod('post'));
    }

    public function test_set_allow_methods_invalid_arg_exception()
    {
        $this->expectException(\InvalidArgumentException::class);
        (new Delete())->setAllowMethod(true);
    }
}
