<?php
declare(strict_types=1);

namespace MixerApi\JsonLdView\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AddressesFixture
 */
class AddressesFixture extends TestFixture
{
    /**
     * @inheritdoc
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'address' => 'Lorem ipsum dolor sit amet',
                'address2' => 'Lorem ipsum dolor sit amet',
                'district' => 'Lorem ipsum dolor ',
                'city_id' => 1,
                'postal_code' => 'Lorem ip',
                'phone' => 'Lorem ipsum dolor ',
                'location' => 'Lorem ipsum dolor sit amet',
                'modified' => '2020-07-11 01:54:20',
            ],
        ];
        parent::init();
    }
}
