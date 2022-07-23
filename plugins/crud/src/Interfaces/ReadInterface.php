<?php
declare(strict_types=1);

namespace MixerApi\Crud\Interfaces;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;

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
     * @param array<string, mixed> $options options accepted by `Table::find()`
     * @return \Cake\Datasource\EntityInterface
     */
    public function read(Controller $controller, mixed $id = null, $options = []): EntityInterface;

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
     * @return \Cake\ORM\Query
     */
    public function query(Controller $controller): Query;
}
