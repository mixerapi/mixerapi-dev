<?php
declare(strict_types=1);

namespace MixerApi\Crud\Services;

use Cake\Controller\Controller;
use Cake\Http\Response;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\TableRegistry;
use MixerApi\Crud\Exception\ResourceWriteException;
use MixerApi\Crud\Interfaces\DeleteInterface;

/**
 * @experimental
 */
class Delete implements DeleteInterface
{
    use CrudTrait;

    /**
     * @var \Cake\ORM\Locator\LocatorInterface
     */
    private $locator;

    /**
     * @var \MixerApi\Crud\Services\Read
     */
    private $read;

    /**
     * @param \Cake\ORM\Locator\LocatorInterface|null $locator locator
     * @param \MixerApi\Crud\Services\Read|null $read read service
     */
    public function __construct(?LocatorInterface $locator = null, ?Read $read = null)
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
