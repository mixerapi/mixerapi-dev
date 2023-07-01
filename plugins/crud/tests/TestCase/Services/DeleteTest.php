<?php

namespace MixerApi\Crud\Test\TestCase\Services;

use Cake\Http\Response;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use MixerApi\Crud\Services\Delete;

class DeleteTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @var string[]
     */
    public array $fixtures = [
        'plugin.MixerApi/Crud.Actors'
    ];

    public function test_respond(): void
    {
        $this->assertInstanceOf(Response::class, (new Delete())->respond(204, (new Response())));
    }
}
