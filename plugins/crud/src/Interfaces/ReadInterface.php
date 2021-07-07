<?php
declare(strict_types=1);

namespace MixerApi\Crud\Interfaces;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;

/**
 * @experimental
 */
interface ReadInterface
{
    /**
     * Reads the resource
     *
     * @param \Cake\Controller\Controller $controller the cakephp controller instance
     * @param string|int|null $id an optional identifier, if null the id parameter is used from the request
     * @return \Cake\Datasource\EntityInterface
     */
    public function read(Controller $controller, $id = null): EntityInterface;

    /**
     * @param string $table the table
     * @return $this
     */
    public function setTableName(string $table);

    /**
     * @param string|array $methods allowed http method(s)
     * @return $this
     */
    public function setAllowMethod($methods);
}
