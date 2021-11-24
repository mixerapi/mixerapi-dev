<?php
declare(strict_types=1);

namespace MixerApi\Core\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ActorsFixture
 */
class ActorsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'first_name' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'last_name' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'last_name' => ['type' => 'index', 'columns' => ['last_name'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '1',
                'first_name' => 'PENELOPE',
                'last_name' => 'GUINESS',
                'modified' => '2006-02-15 04:34:33',
            ],
            [
                'id' => '2',
                'first_name' => 'NICK',
                'last_name' => 'WAHLBERG',
                'modified' => '2006-02-15 04:34:33',
            ],
            [
                'id' => '3',
                'first_name' => 'ED',
                'last_name' => 'CHASE',
                'modified' => '2006-02-15 04:34:33',
            ],
            [
                'id' => '4',
                'first_name' => 'JENNIFER',
                'last_name' => 'DAVIS',
                'modified' => '2006-02-15 04:34:33',
            ],
            [
                'id' => '5',
                'first_name' => 'JOHNNY',
                'last_name' => 'LOLLOBRIGIDA',
                'modified' => '2006-02-15 04:34:33',
            ],
            [
                'id' => '6',
                'first_name' => 'BETTE',
                'last_name' => 'NICHOLSON',
                'modified' => '2006-02-15 04:34:33',
            ],
            [
                'id' => '7',
                'first_name' => 'GRACE',
                'last_name' => 'MOSTEL',
                'modified' => '2006-02-15 04:34:33',
            ],
            [
                'id' => '8',
                'first_name' => 'MATTHEW',
                'last_name' => 'JOHANSSON',
                'modified' => '2006-02-15 04:34:33',
            ],
            [
                'id' => '9',
                'first_name' => 'JOE',
                'last_name' => 'SWANK',
                'modified' => '2006-02-15 04:34:33',
            ],
            [
                'id' => '10',
                'first_name' => 'CHRISTIAN',
                'last_name' => 'GABLE',
                'modified' => '2006-02-15 04:34:33',
            ],
        ];
        parent::init();
    }
}
