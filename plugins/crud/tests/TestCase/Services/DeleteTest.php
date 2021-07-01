<?php

namespace MixerApi\Crud\Test\TestCase\Services;

use Cake\Http\Response;
use Cake\TestSuite\TestCase;
use MixerApi\Crud\Services\Delete;

class DeleteTest extends TestCase
{
    public function test_respond()
    {
        $this->assertInstanceOf(Response::class, (new Delete())->respond(204, (new Response())));
    }
}
