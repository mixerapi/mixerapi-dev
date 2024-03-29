<?php
declare(strict_types=1);

namespace MixerApi\CollectionView\Test\App\Model\Entity;

use Cake\ORM\Entity;

class FilmActor extends Entity
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
    protected array $_accessible = [
        'actor_id' => true,
        'film_id' => true,
        'modified' => true,
        'actor' => true,
        'film' => true,
    ];
}
