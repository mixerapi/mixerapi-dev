<?php

namespace MixerApi\Crud\Test\TestCase\Services;

use Cake\Http\Response;
use Cake\TestSuite\TestCase;
use MixerApi\Crud\Services\Delete;

class CrudTraitTest extends TestCase
{
    public function test_set_table_name(): void
    {
        $this->assertInstanceOf(Delete::class, (new Delete())->setTableName('name'));
    }

    public function test_set_allow_methods(): void
    {
        $this->assertInstanceOf(Delete::class, (new Delete())->setAllowMethod('post'));
    }
}
