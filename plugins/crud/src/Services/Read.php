<?php
declare(strict_types=1);

namespace MixerApi\Crud\Services;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\TableRegistry;
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
     * @param \Cake\ORM\Locator\LocatorInterface|null $locator LocatorInterface to locate the table.
     */
    public function __construct(private ?LocatorInterface $locator = null)
    {
        $this->locator = $locator ?? TableRegistry::getTableLocator();
    }

    /**
     * @inheritDoc
     */
    public function read(Controller $controller, $id = null): EntityInterface
    {
        $this->allowMethods($controller);

        $id = $this->whichId($controller, $id);

        return $this->locator->get($this->whichTable($controller))->get($id, [
            'contain' => [],
        ]);
    }
}
