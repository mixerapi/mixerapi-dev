<?php
declare(strict_types=1);

namespace MixerApi\Crud\Services;

use Cake\Controller\Controller;
use Cake\Http\Response;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\TableRegistry;
use MixerApi\Crud\Exception\ResourceWriteException;
use MixerApi\Crud\Interfaces\DeleteInterface;
use MixerApi\Crud\Interfaces\ReadInterface;

/**
 * Implements DeleteInterface and provides delete functionality.
 *
 * @experimental
 */
class Delete implements DeleteInterface
{
    use CrudTrait;

    /**
     * @param \Cake\ORM\Locator\LocatorInterface|null $locator LocatorInterface to locate the table.
     * @param \MixerApi\Crud\Interfaces\ReadInterface|null $read ReadInterface used to find the record to be deleted.
     */
    public function __construct(private ?LocatorInterface $locator = null, private ?ReadInterface $read = null)
    {
        $this->locator = $locator ?? TableRegistry::getTableLocator();
        $this->read = $read ?? new Read();
    }

    /**
     * @inheritDoc
     */
    public function delete(Controller $controller, $id = null)
    {
        $this->allowMethods($controller);

        $id = $this->whichId($controller, $id);
        $entity = $this->read->read($controller, $id);

        if (!$this->locator->get($this->whichTable($controller))->delete($entity)) {
            throw new ResourceWriteException($entity, "Unable to save $this->tableName resource.");
        }

        return $this;
    }

    /**
     * Deletes the record and returns a Response object with status code (default: 204)
     *
     * @param int $status defaults to 204
     * @param \Cake\Http\Response|null $response a response object
     * @return \Cake\Http\Response
     */
    public function respond(int $status = 204, ?Response $response = null): Response
    {
        if ($response) {
            return $response->withStatus($status);
        }

        return (new Response())->withStatus($status);
    }
}
