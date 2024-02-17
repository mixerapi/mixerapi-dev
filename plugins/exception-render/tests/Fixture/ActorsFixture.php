<?php
declare(strict_types=1);

namespace MixerApi\ExceptionRender\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

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
            ]
        ];
        parent::init();
    }
}
