<?php
declare(strict_types=1);

namespace MixerApi\Crud\Services;

use Cake\Controller\Controller;

/**
 * @experimental
 */
trait CrudTrait
{
    /**
     * @var string|null
     */
    private ?string $tableName;

    /**
     * @var array
     */
    private array $methods = [];

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
    public function setAllowMethod(string|array $methods)
    {
        $this->methods = is_string($methods) ? [$methods] : $methods;

        return $this;
    }

    /**
     * @param \Cake\Controller\Controller $controller a cakephp controller instance
     * @return void
     */
    private function allowMethods(Controller $controller): void
    {
        if (count($this->methods)) {
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
    private function whichId(Controller $controller, mixed $id): mixed
    {
        return $id ?? $controller->getRequest()->getParam('id');
    }
}
