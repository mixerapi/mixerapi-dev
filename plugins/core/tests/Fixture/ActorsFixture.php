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
            [
                'id' => '11',
                'first_name' => 'ZERO',
                'last_name' => 'CAGE',
                'modified' => '2006-02-15 04:34:33',
            ],
            [
                'id' => '12',
                'first_name' => 'KARL',
                'last_name' => 'BERRY',
                'modified' => '2006-02-15 04:34:33',
            ],
            [
                'id' => '13',
                'first_name' => 'UMA',
                'last_name' => 'WOOD',
                'modified' => '2006-02-15 04:34:33',
            ],
            [
                'id' => '14',
                'first_name' => 'VIVIEN',
                'last_name' => 'BERGEN',
                'modified' => '2006-02-15 04:34:33',
            ],
            [
                'id' => '15',
                'first_name' => 'CUBA',
                'last_name' => 'OLIVIER',
                'modified' => '2006-02-15 04:34:33',
            ],
            [
                'id' => '16',
                'first_name' => 'FRED',
                'last_name' => 'COSTNER',
                'modified' => '2006-02-15 04:34:33',
            ],
            [
                'id' => '17',
                'first_name' => 'HELEN',
                'last_name' => 'VOIGHT',
                'modified' => '2006-02-15 04:34:33',
            ],
            [
                'id' => '18',
                'first_name' => 'DAN',
                'last_name' => 'TORN',
                'modified' => '2006-02-15 04:34:33',
            ],
            [
                'id' => '19',
                'first_name' => 'BOB',
                'last_name' => 'FAWCETT',
                'modified' => '2006-02-15 04:34:33',
            ],
            [
                'id' => '20',
                'first_name' => 'LUCILLE',
                'last_name' => 'TRACY',
                'modified' => '2006-02-15 04:34:33',
            ],
        ];
        parent::init();
    }
}
