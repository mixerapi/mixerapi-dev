<?php
declare(strict_types=1);

namespace MixerApi\ExceptionRender\Test\Fixture;

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
            ]
        ];
        parent::init();
    }
}
