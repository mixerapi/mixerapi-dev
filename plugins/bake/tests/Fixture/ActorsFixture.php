<?php
declare(strict_types=1);

namespace MixerApi\Bake\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ActorsFixture
 */
class ActorsFixture  extends TestFixture
{
    /**
     * @inheritdoc
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'first_name' => 'Lorem ipsum dolor sit amet',
                'last_name' => 'Lorem ipsum dolor sit amet',
                'modified' => '2020-07-11 01:54:20',
            ],
        ];
        parent::init();
    }
}
