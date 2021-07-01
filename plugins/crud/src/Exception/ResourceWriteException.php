<?php
declare(strict_types=1);

namespace MixerApi\Crud\Exception;

use Cake\Datasource\EntityInterface;
use Cake\Http\Exception\HttpException;
use Throwable;

class ResourceWriteException extends HttpException
{
    /**
     * @var \Cake\Datasource\EntityInterface
     */
    private $entity;

    /**
     * @param \Cake\Datasource\EntityInterface|null $entity the entity
     * @param string $message error message
     * @param int|null $code status code
     * @param \Throwable|null $previous throwable
     */
    public function __construct(?EntityInterface $entity, $message = '', ?int $code = null, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->entity = $entity;
    }

    /**
     * @return \Cake\Datasource\EntityInterface
     */
    public function getEntity(): EntityInterface
    {
        return $this->entity;
    }
}
