<?php
declare(strict_types=1);

namespace MixerApi\Core\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FilmsFixture
 */
class FilmsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'title' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'description' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'release_year' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'language_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'rental_duration' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => '3', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        //'rental_rate' => ['type' => 'decimal', 'length' => 4, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '4.99', 'comment' => ''],
        'length' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        //'replacement_cost' => ['type' => 'decimal', 'length' => 5, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '19.99', 'comment' => ''],
        'rating' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => 'G', 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'special_features' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'title' => ['type' => 'index', 'columns' => ['title'], 'length' => []],
            'language_id' => ['type' => 'index', 'columns' => ['language_id'], 'length' => []],
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
                'title' => 'ACADEMY DINOSAUR',
                'description' => 'A Epic Drama of a Feminist And a Mad Scientist who must Battle a Teacher in The Canadian Rockies',
                'release_year' => '2006',
                'language_id' => '1',
                'rental_duration' => '6',
                'rental_rate' => '0.99',
                'length' => '86',
                'replacement_cost' => '20.99',
                'rating' => 'PG',
                'special_features' => 'Deleted Scenes,Behind the Scenes',
                'modified' => '2006-02-15 05:03:42',
            ],
            [
                'id' => '2',
                'title' => 'ACE GOLDFINGER',
                'description' => 'A Astounding Epistle of a Database Administrator And a Explorer who must Find a Car in Ancient China',
                'release_year' => '2006',
                'language_id' => '1',
                'rental_duration' => '3',
                'rental_rate' => '4.99',
                'length' => '48',
                'replacement_cost' => '12.99',
                'rating' => 'G',
                'special_features' => 'Trailers,Deleted Scenes',
                'modified' => '2006-02-15 05:03:42',
            ],
            [
                'id' => '3',
                'title' => 'ADAPTATION HOLES',
                'description' => 'A Astounding Reflection of a Lumberjack And a Car who must Sink a Lumberjack in A Baloon Factory',
                'release_year' => '2006',
                'language_id' => '1',
                'rental_duration' => '7',
                'rental_rate' => '2.99',
                'length' => '50',
                'replacement_cost' => '18.99',
                'rating' => 'NC-17',
                'special_features' => 'Trailers,Deleted Scenes',
                'modified' => '2006-02-15 05:03:42',
            ],
            [
                'id' => '4',
                'title' => 'AFFAIR PREJUDICE',
                'description' => 'A Fanciful Documentary of a Frisbee And a Lumberjack who must Chase a Monkey in A Shark Tank',
                'release_year' => '2006',
                'language_id' => '1',
                'rental_duration' => '5',
                'rental_rate' => '2.99',
                'length' => '117',
                'replacement_cost' => '26.99',
                'rating' => 'G',
                'special_features' => 'Commentaries,Behind the Scenes',
                'modified' => '2006-02-15 05:03:42',
            ],
            [
                'id' => '5',
                'title' => 'AFRICAN EGG',
                'description' => 'A Fast-Paced Documentary of a Pastry Chef And a Dentist who must Pursue a Forensic Psychologist in The Gulf of Mexico',
                'release_year' => '2006',
                'language_id' => '1',
                'rental_duration' => '6',
                'rental_rate' => '2.99',
                'length' => '130',
                'replacement_cost' => '22.99',
                'rating' => 'G',
                'special_features' => 'Deleted Scenes',
                'modified' => '2006-02-15 05:03:42',
            ],
            [
                'id' => '6',
                'title' => 'AGENT TRUMAN',
                'description' => 'A Intrepid Panorama of a Robot And a Boy who must Escape a Sumo Wrestler in Ancient China',
                'release_year' => '2006',
                'language_id' => '1',
                'rental_duration' => '3',
                'rental_rate' => '2.99',
                'length' => '169',
                'replacement_cost' => '17.99',
                'rating' => 'PG',
                'special_features' => 'Deleted Scenes',
                'modified' => '2006-02-15 05:03:42',
            ],
            [
                'id' => '7',
                'title' => 'AIRPLANE SIERRA',
                'description' => 'A Touching Saga of a Hunter And a Butler who must Discover a Butler in A Jet Boat',
                'release_year' => '2006',
                'language_id' => '1',
                'rental_duration' => '6',
                'rental_rate' => '4.99',
                'length' => '62',
                'replacement_cost' => '28.99',
                'rating' => 'PG-13',
                'special_features' => 'Trailers,Deleted Scenes',
                'modified' => '2006-02-15 05:03:42',
            ],
            [
                'id' => '8',
                'title' => 'AIRPORT POLLOCK',
                'description' => 'A Epic Tale of a Moose And a Girl who must Confront a Monkey in Ancient India',
                'release_year' => '2006',
                'language_id' => '1',
                'rental_duration' => '6',
                'rental_rate' => '4.99',
                'length' => '54',
                'replacement_cost' => '15.99',
                'rating' => 'R',
                'special_features' => 'Trailers',
                'modified' => '2006-02-15 05:03:42',
            ],
            [
                'id' => '9',
                'title' => 'ALABAMA DEVIL',
                'description' => 'A Thoughtful Panorama of a Database Administrator And a Mad Scientist who must Outgun a Mad Scientist in A Jet Boat',
                'release_year' => '2006',
                'language_id' => '1',
                'rental_duration' => '3',
                'rental_rate' => '2.99',
                'length' => '114',
                'replacement_cost' => '21.99',
                'rating' => 'PG-13',
                'special_features' => 'Trailers,Deleted Scenes',
                'modified' => '2006-02-15 05:03:42',
            ],
            [
                'id' => '10',
                'title' => 'ALADDIN CALENDAR',
                'description' => 'A Action-Packed Tale of a Man And a Lumberjack who must Reach a Feminist in Ancient China',
                'release_year' => '2006',
                'language_id' => '1',
                'rental_duration' => '6',
                'rental_rate' => '4.99',
                'length' => '63',
                'replacement_cost' => '24.99',
                'rating' => 'NC-17',
                'special_features' => 'Trailers,Deleted Scenes',
                'modified' => '2006-02-15 05:03:42',
            ]
        ];
        parent::init();
    }
}
