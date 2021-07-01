<?php
declare(strict_types=1);

namespace MixerApi\Crud\Services;

use Cake\Controller\Controller;
use InvalidArgumentException;

trait CrudTrait
{
    /**
     * @var string
     */
    private $tableName;

    /**
     * @var array
     */
    private $methods;

    /**
     * @param string $table table name
     * @return $this
     */
    public function setTableName(string $table)
    {
        $this->tableName = $table;

        return $this;
    }

    /**
     * @param string|array $methods allowed http method(s)
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setAllowMethod($methods)
    {
        if (!is_string($methods) && !is_array($methods)) {
            throw new InvalidArgumentException('Argument must be a string or an array of strings');
        }

        $this->methods = is_string($methods) ? [$methods] : $methods;

        return $this;
    }

    /**
     * @param \Cake\Controller\Controller $controller a cakephp controller instance
     * @return void
     */
    private function allowMethods(Controller $controller): void
    {
        if (is_array($this->methods)) {
            $controller->getRequest()->allowMethod($this->methods);
        }
    }

    /**
     * @param \Cake\Controller\Controller $controller a cakephp controller instance
     * @return string
     */
    private function whichTable(Controller $controller): string
    {
        return $this->tableName ?? $controller->getName();
    }

    /**
     * @param \Cake\Controller\Controller $controller a cakephp controller instance
     * @param mixed $id the resource identifier
     * @return mixed
     */
    private function whichId(Controller $controller, $id)
    {
        return $id ?? $controller->getRequest()->getParam('id');
    }
}
