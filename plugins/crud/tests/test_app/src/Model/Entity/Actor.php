<?php
declare(strict_types=1);

namespace MixerApi\Crud\Test\App\Model\Entity;

use Cake\ORM\Entity;
use MixerApi\Crud\HalResourceInterface;
use Cake\Datasource\EntityInterface;

class Actor extends Entity
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
        'first_name' => true,
        'last_name' => true,
        'modified' => true,
        'film_actors' => true,
    ];
}
