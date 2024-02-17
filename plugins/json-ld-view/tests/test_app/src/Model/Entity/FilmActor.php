<?php
declare(strict_types=1);

namespace MixerApi\JsonLdView\Test\App\Model\Entity;

use Cake\ORM\Entity;

class FilmActor extends Entity
{
    /**
     * @inheritDoc
     */
    protected array $_accessible = [
        'actor_id' => true,
        'film_id' => true,
        'modified' => true,
        'actor' => true,
        'film' => true,
    ];
}
