<?php
declare(strict_types=1);

namespace MixerApi\JsonLdView\Test\App\Model\Entity;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Entity;
use MixerApi\JsonLdView\JsonLdDataInterface;
use MixerApi\JsonLdView\JsonLdSchema;

/**
 * Address Entity
 *
 * @property int $id
 * @property string $address
 * @property string|null $address2
 * @property string $district
 * @property int $city_id
 * @property string|null $postal_code
 * @property string $phone
 * @property string $location
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Customer[] $customers
 * @property \App\Model\Entity\Employee[] $employees
 * @property \App\Model\Entity\Store[] $stores
 */
class Address extends Entity implements JsonLdDataInterface
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'address' => true,
        'address2' => true,
        'district' => true,
        'city_id' => true,
        'postal_code' => true,
        'phone' => true,
        'location' => true,
        'modified' => true,
        'city' => true,
        'customers' => true,
        'employees' => true,
        'stores' => true,
    ];

    /**
     * @return string
     */
    public function getJsonLdContext(): string
    {
        return '/contexts/Address';
    }

    /**
     * @return string
     */
    public function getJsonLdType(): string
    {
        return 'https://schema.org/address';
    }

    /**
     * @param EntityInterface $entity
     * @return array|\string[][]
     */
    public function getJsonLdIdentifier(EntityInterface $entity): string
    {
        return '/addresses/' . $entity->get('id');
    }

    /**
     * @return \MixerApi\JsonLdView\JsonLdSchema[]
     */
    public function getJsonLdSchemas(): array
    {
        return [];
    }
}
