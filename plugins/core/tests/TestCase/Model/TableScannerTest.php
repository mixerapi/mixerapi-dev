<?php

namespace MixerApi\Core\Test\TestCase\Model;

use Cake\Database\Connection;
use Cake\Database\Schema\CollectionInterface as SchemaCollectionInterface;
use Cake\Datasource\ConnectionInterface;
use Cake\TestSuite\TestCase;
use MixerApi\Core\Model\TableScanner;
use Cake\Datasource\ConnectionManager;

class TableScannerTest extends TestCase
{
    /**
     * @var string[]
     */
    protected array $fixtures = [
        'plugin.MixerApi/Core.Actors',
    ];

    protected ?ConnectionInterface $connection;

    public function setUp(): void
    {
        parent::setUp();
        $this->connection = ConnectionManager::get('test');
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * When `listAll()` is called a list of tables available in the connection is returned.
     */
    public function test_list_all(): void
    {
        $result = (new TableScanner($this->connection))->listAll();
        $this->assertArrayHasKey('actors', $result);
    }

    /**
     * When `listAll()` is called a list of tables that have not been marked as skipped in the connection is returned.
     */
    public function test_list_unskipped(): void
    {
        $result = (new TableScanner($this->connection))->listUnskipped();
        $this->assertArrayHasKey('actors', $result);
    }
}
