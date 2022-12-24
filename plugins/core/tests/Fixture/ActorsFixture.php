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
     * @inheritdoc
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '1',
                'first_name' => 'PENELOPE',
                'last_name' => 'GUINESS',
                'modified' => '2006-02-15 04:34:33',
                'write' => 'wo',
                'read' => 'ro',
                'hide' => 'hidden',
            ],
            [
                'id' => '2',
                'first_name' => 'NICK',
                'last_name' => 'WAHLBERG',
                'modified' => '2006-02-15 04:34:33',
                'write' => 'wo',
                'read' => 'ro',
                'hide' => 'hidden',
            ],
            [
                'id' => '3',
                'first_name' => 'ED',
                'last_name' => 'CHASE',
                'modified' => '2006-02-15 04:34:33',
                'write' => 'wo',
                'read' => 'ro',
                'hide' => 'hidden',
            ],
            [
                'id' => '4',
                'first_name' => 'JENNIFER',
                'last_name' => 'DAVIS',
                'modified' => '2006-02-15 04:34:33',
                'write' => 'wo',
                'read' => 'ro',
                'hide' => 'hidden',
            ],
            [
                'id' => '5',
                'first_name' => 'JOHNNY',
                'last_name' => 'LOLLOBRIGIDA',
                'modified' => '2006-02-15 04:34:33',
                'write' => 'wo',
                'read' => 'ro',
                'hide' => 'hidden',
            ],
            [
                'id' => '6',
                'first_name' => 'BETTE',
                'last_name' => 'NICHOLSON',
                'modified' => '2006-02-15 04:34:33',
                'write' => 'wo',
                'read' => 'ro',
                'hide' => 'hidden',
            ],
            [
                'id' => '7',
                'first_name' => 'GRACE',
                'last_name' => 'MOSTEL',
                'modified' => '2006-02-15 04:34:33',
                'write' => 'wo',
                'read' => 'ro',
                'hide' => 'hidden',
            ],
            [
                'id' => '8',
                'first_name' => 'MATTHEW',
                'last_name' => 'JOHANSSON',
                'modified' => '2006-02-15 04:34:33',
                'write' => 'wo',
                'read' => 'ro',
                'hide' => 'hidden',
            ],
            [
                'id' => '9',
                'first_name' => 'JOE',
                'last_name' => 'SWANK',
                'modified' => '2006-02-15 04:34:33',
                'write' => 'wo',
                'read' => 'ro',
                'hide' => 'hidden',
            ],
            [
                'id' => '10',
                'first_name' => 'CHRISTIAN',
                'last_name' => 'GABLE',
                'modified' => '2006-02-15 04:34:33',
                'write' => 'wo',
                'read' => 'ro',
                'hide' => 'hidden',
            ],
        ];
        parent::init();
    }
}
