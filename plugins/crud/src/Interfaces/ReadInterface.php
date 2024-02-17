<?php
declare(strict_types=1);

namespace MixerApi\Crud\Interfaces;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query\SelectQuery;
use Closure;
use Psr\SimpleCache\CacheInterface;

/**
 * @experimental
 */
interface ReadInterface
{
    /**
     * Reads the resource
     *
     * @param \Cake\Controller\Controller $controller the cakephp controller instance
     * @param mixed $id an optional identifier, if null the id parameter is used from the request
     * @param array|string $finder See CakePHP docs
     * @param \Psr\SimpleCache\CacheInterface|string|null $cache See CakePHP docs
     * @param \Closure|string|null $cacheKey See CakePHP docs
     * @param mixed ...$args See CakePHP docs
     * @return \Cake\Datasource\EntityInterface
     */
    public function read(
        Controller $controller,
        mixed $id = null,
        array|string $finder = 'all',
        CacheInterface|string|null $cache = null,
        Closure|string|null $cacheKey = null,
        mixed ...$args
    ): EntityInterface;

    /**
     * @param string $table the table
     * @return $this
     */
    public function setTableName(string $table);

    /**
     * @param string|array $methods allowed http method(s)
     * @return $this
     */
    public function setAllowMethod(string|array $methods);

    /**
     * Builds a Query object and returns it
     *
     * @param \Cake\Controller\Controller $controller the cakephp controller instance
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function query(Controller $controller): SelectQuery;
}
