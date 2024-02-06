<?php
declare(strict_types=1);

namespace MixerApi\Crud\Services;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query\SelectQuery;
use Closure;
use MixerApi\Crud\Interfaces\ReadInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * Implements ReadInterface and provides basic read functionality.
 *
 * @experimental
 */
class Read implements ReadInterface
{
    use CrudTrait;

    /**
     * @inheritDoc
     */
    public function read(
        Controller $controller,
        mixed $id = null,
        array|string $finder = 'all',
        CacheInterface|string|null $cache = null,
        Closure|string|null $cacheKey = null,
        mixed ...$args
    ): EntityInterface {
        $this->allowMethods($controller);
        $id = $this->whichId($controller, $id);
        $table = $controller->getTableLocator()->get($this->whichTable($controller));

        return $table->get(primaryKey: $id, finder: $finder, cache: $cache, cacheKey: $cacheKey, args: $args);
    }

    /**
     * @inheritDoc
     */
    public function query(Controller $controller): SelectQuery
    {
        return $controller->getTableLocator()->get($this->whichTable($controller))->query();
    }
}
