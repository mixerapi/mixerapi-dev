<?php

namespace MixerApi\Crud\Test\TestCase\Services;

use Cake\Http\Response;
use Cake\ORM\Entity;
use Cake\ORM\Locator\TableLocator;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use MixerApi\Crud\Exception\ResourceWriteException;
use MixerApi\Crud\Services\Delete;
use MixerApi\Crud\Services\Read;
use MixerApi\Crud\Test\App\Controller\ActorsController;
use MixerApi\Crud\Test\App\Model\Table\ActorsTable;

class DeleteTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @var string[]
     */
    public $fixtures = [
        'plugin.MixerApi/Crud.Actors'
    ];

    public function test_respond(): void
    {
        $this->assertInstanceOf(Response::class, (new Delete())->respond(204, (new Response())));
    }

    public function test_delete_throws_resource_write_exception(): void
    {
        $mockTable = $this->createPartialMock(ActorsTable::class, ['delete']);
        $mockTable->expects($this->once())
            ->method('delete')
            ->willReturn(false);

        $mockLocator = $this->createPartialMock(TableLocator::class, ['get']);
        $mockLocator->expects($this->once())
            ->method('get')
            ->willReturn($mockTable);

        $mockController = $this->createPartialMock(ActorsController::class, [
            'getTableLocator','getName'
        ]);
        $mockController->expects($this->once())
            ->method('getTableLocator')
            ->will($this->returnValue($mockLocator));
        $mockController->expects($this->once())
            ->method('getName')
            ->willReturn('Actors');

        $mockRead = $this->createPartialMock(Read::class, ['read']);
        $mockRead->expects($this->once())
            ->method('read')
            ->willReturn(new Entity());

        $this->expectException(ResourceWriteException::class);
        (new Delete($mockRead))->delete($mockController, 1);
    }
}
