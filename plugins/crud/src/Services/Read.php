<?php
declare(strict_types=1);

namespace MixerApi\Crud\Services;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\TableRegistry;
use MixerApi\Crud\Interfaces\ReadInterface;

/**
 * @experimental
 */
class Read implements ReadInterface
{
    use CrudTrait;

    /**
     * @var \Cake\ORM\Locator\LocatorInterface
     */
    private $locator;

    /**
     * @param \Cake\ORM\Locator\LocatorInterface|null $locator locator
     */
    public function __construct(?LocatorInterface $locator = null)
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
