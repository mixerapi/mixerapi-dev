<?php


/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         2.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace MixerApi\Core\Test\TestCase\Model;

use Cake\TestSuite\TestCase;
use MixerApi\Core\Model\TableScanner;
use Cake\Datasource\ConnectionManager;

class TableScannerTest extends TestCase
{
    /**
     * @var string[]
     */
    protected $fixtures = [
        'plugin.MixerApi/Core.Actors',
    ];

    /**
     * @var \Cake\Database\Connection
     */
    protected $connection;

    public function setUp(): void
    {
        parent::setUp();
        $this->connection = ConnectionManager::get('test');
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_list_all(): void
    {
        $result = (new TableScanner($this->connection))->listAll();
        $this->assertArrayHasKey('actors', $result);
    }

    public function test_list_unskipped(): void
    {
        $result = (new TableScanner($this->connection))->listUnskipped();
        $this->assertArrayHasKey('actors', $result);
    }

    public function test_list_unskipped_with_skipped(): void
    {
        $tableScanner = new TableScanner(
            $this->connection,
            ['i18n', 'cake_sessions', 'sessions', '/phinxlog/', 'actors','films','film_actors', 'departments']
        );

        $result = $tableScanner->listUnskipped();

        $this->assertCount(0, $result);
    }
}
