<?php
declare(strict_types=1);

namespace MixerApi\ExceptionRender;

use Cake\Core\Exception\Exception;
use Cake\Datasource\EntityInterface;

class ValidationException extends Exception
{
    /**
     * @inheritDoc
     */
    protected $_defaultCode = 422;

    /**
     * @var \Cake\Datasource\EntityInterface
     */
    private $entity;

    /**
     * @param string|null $message a custom message, otherwise `Error saving resource` is used
     * @param \Cake\Datasource\EntityInterface $entity EntityInterface
     */
    public function __construct(?string $message = null, EntityInterface $entity)
    {
        $this->entity = $entity;

        parent::__construct($message ?? 'Error saving resource', null, null);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        $return = [];

        foreach ($this->entity->getErrors() as $propertyName => $propertyErrors) {
            $property = ['propertyPath' => $propertyName];
            foreach ($propertyErrors as $rule => $message) {
                $property['messages'][] = ['rule' => $rule, 'message' => $message];
            }
            $return[] = $property;
        }

        return $return;
    }
}
