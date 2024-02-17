<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth;

use Cake\Core\ContainerInterface;
use Cake\Core\ServiceProvider;
use MixerApi\JwtAuth\Configuration\Configuration;
use MixerApi\JwtAuth\Jwk\JwkSet;
use MixerApi\JwtAuth\Jwk\JwkSetInterface;

/**
 * @link https://book.cakephp.org/4/en/development/dependency-injection.html
 */
class JwtAuthServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    protected array $provides = [
        JwtAuthenticatorInterface::class,
        JwkSetInterface::class,
    ];

    /**
     * @inheritDoc
     */
    public function services(ContainerInterface $container): void
    {
        $configuration = new Configuration();

        $container->add(JwkSetInterface::class, JwkSet::class)
            ->addArguments([$configuration]);
        $container->add(JwtAuthenticatorInterface::class, JwtAuthenticator::class)
            ->addArguments([$configuration]);
    }
}
