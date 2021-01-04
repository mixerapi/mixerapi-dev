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
     * @var \Cake\Datasource\EntityInterface|null
     */
    private $entity;

    /**
     * @param \Cake\Datasource\EntityInterface $entity EntityInterface
     * @param string|null $message a custom message, otherwise `Error saving resource` is used
     */
    public function __construct(?EntityInterface $entity = null, ?string $message = null)
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

        if ($this->entity === null) {
            return $return;
        }

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
