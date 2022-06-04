<?php
declare(strict_types=1);

namespace MixerApi\Crud\Test\Fixture;

/**
 * ActorsFixture
 */
class ActorsFixture extends \App\Test\Fixture\ActorsFixture
{
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
            ]
        ];
        parent::init();
    }
}
