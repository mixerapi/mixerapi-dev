<?php
declare(strict_types=1);

namespace MixerApi\Crud\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FilmsFixture
 */
class FilmsFixture extends TestFixture
{
    /**
     * @inheritdoc
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
        ];
        parent::init();
    }
}
