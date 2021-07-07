<?php
declare(strict_types=1);

namespace MixerApi\Crud;

use Cake\Core\ContainerInterface;
use Cake\Core\ServiceProvider;
use MixerApi\Crud\Interfaces\CreateInterface;
use MixerApi\Crud\Interfaces\DeleteInterface;
use MixerApi\Crud\Interfaces\ReadInterface;
use MixerApi\Crud\Interfaces\SearchInterface;
use MixerApi\Crud\Interfaces\UpdateInterface;
use MixerApi\Crud\Services\Create;
use MixerApi\Crud\Services\Delete;
use MixerApi\Crud\Services\Read;
use MixerApi\Crud\Services\Search;
use MixerApi\Crud\Services\Update;

/**
 * @experimental
 */
class CrudServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    protected $provides = [
        CreateInterface::class,
        ReadInterface::class,
        UpdateInterface::class,
        DeleteInterface::class,
        SearchInterface::class,
    ];

    /**
     * @inheritDoc
     */
    public function services(ContainerInterface $container): void
    {
        $container->add(CreateInterface::class, Create::class);
        $container->add(ReadInterface::class, Read::class);
        $container->add(UpdateInterface::class, Update::class);
        $container->add(DeleteInterface::class, Delete::class);
        $container->add(SearchInterface::class, Search::class);
    }
}
