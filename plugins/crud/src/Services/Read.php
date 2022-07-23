<?php
declare(strict_types=1);

namespace MixerApi\Crud\Services;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use MixerApi\Crud\Interfaces\ReadInterface;

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
    public function read(Controller $controller, mixed $id = null, $options = []): EntityInterface
    {
        $this->allowMethods($controller);
        $id = $this->whichId($controller, $id);
        $table = $controller->getTableLocator()->get($this->whichTable($controller));

        return $table->get($id, $options);
    }

    /**
     * @inheritDoc
     */
    public function query(Controller $controller): Query
    {
        return $controller->getTableLocator()->get($this->whichTable($controller))->query();
    }
}
