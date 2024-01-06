<?php
declare(strict_types=1);

namespace MixerApi\Crud\Interfaces;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;

/**
 * @experimental
 */
interface CreateInterface
{
    /**
     * Creates the resource
     *
     * @param \Cake\Controller\Controller $controller the cakephp controller instance
     * @param \ArrayAccess|array $options The options to use when saving.
     * @return \Cake\Datasource\EntityInterface
     */
    public function save(Controller $controller, \ArrayAccess|array $options = []): EntityInterface;

    /**
     * @param string $table the table name
     * @return $this
     */
    public function setTableName(string $table);

    /**
     * @param string|array $methods allowed http method(s)
     * @return $this
     */
    public function setAllowMethod(string|array $methods);
}
