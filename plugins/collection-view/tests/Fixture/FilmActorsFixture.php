<?php
declare(strict_types=1);

namespace MixerApi\CollectionView\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FilmActorsFixture
 */
class FilmActorsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'uuid' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'actor_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'film_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['uuid'], 'length' => []],
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
                'uuid' => '9d90c283-8433-11ea-82ad-2079182842a9',
                'actor_id' => '1',
                'film_id' => '1',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c395-8433-11ea-82ad-2079182842a9',
                'actor_id' => '1',
                'film_id' => '23',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c3bc-8433-11ea-82ad-2079182842a9',
                'actor_id' => '1',
                'film_id' => '25',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c3d3-8433-11ea-82ad-2079182842a9',
                'actor_id' => '1',
                'film_id' => '106',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c3e8-8433-11ea-82ad-2079182842a9',
                'actor_id' => '1',
                'film_id' => '140',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c3ff-8433-11ea-82ad-2079182842a9',
                'actor_id' => '1',
                'film_id' => '166',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c414-8433-11ea-82ad-2079182842a9',
                'actor_id' => '1',
                'film_id' => '277',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c42b-8433-11ea-82ad-2079182842a9',
                'actor_id' => '1',
                'film_id' => '361',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c43e-8433-11ea-82ad-2079182842a9',
                'actor_id' => '1',
                'film_id' => '438',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c451-8433-11ea-82ad-2079182842a9',
                'actor_id' => '1',
                'film_id' => '499',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c465-8433-11ea-82ad-2079182842a9',
                'actor_id' => '1',
                'film_id' => '506',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c478-8433-11ea-82ad-2079182842a9',
                'actor_id' => '1',
                'film_id' => '509',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c48c-8433-11ea-82ad-2079182842a9',
                'actor_id' => '1',
                'film_id' => '605',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c49f-8433-11ea-82ad-2079182842a9',
                'actor_id' => '1',
                'film_id' => '635',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c4b2-8433-11ea-82ad-2079182842a9',
                'actor_id' => '1',
                'film_id' => '749',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c4c4-8433-11ea-82ad-2079182842a9',
                'actor_id' => '1',
                'film_id' => '832',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c4d7-8433-11ea-82ad-2079182842a9',
                'actor_id' => '1',
                'film_id' => '939',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c4ea-8433-11ea-82ad-2079182842a9',
                'actor_id' => '1',
                'film_id' => '970',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c4fd-8433-11ea-82ad-2079182842a9',
                'actor_id' => '1',
                'film_id' => '980',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c50f-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '3',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c523-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '31',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c536-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '47',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c548-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '105',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c55a-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '132',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c56e-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '145',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c580-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '226',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c593-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '249',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c5a6-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '314',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c5b8-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '321',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c5ca-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '357',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c5df-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '369',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c5f2-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '399',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c604-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '458',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c617-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '481',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c629-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '485',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c63c-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '518',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c64f-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '540',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c661-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '550',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c673-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '555',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c686-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '561',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c698-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '742',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c6aa-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '754',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c6bd-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '811',
                'modified' => '2020-04-21 20:53:00',
            ],
            [
                'uuid' => '9d90c6cf-8433-11ea-82ad-2079182842a9',
                'actor_id' => '2',
                'film_id' => '958',
                'modified' => '2020-04-21 20:53:00',
            ],
        ];
        parent::init();
    }
}
