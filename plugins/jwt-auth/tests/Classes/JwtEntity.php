<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Test\Classes;

use Cake\ORM\Entity;
use MixerApi\JwtAuth\Jwt\Jwt;
use MixerApi\JwtAuth\Jwt\JwtEntityInterface;
use MixerApi\JwtAuth\Jwt\JwtInterface;

class JwtEntity extends Entity implements JwtEntityInterface
{
    public function getJwt(): JwtInterface
    {
        return new Jwt(time() + 60 * 60 *24, '123');
    }
}
