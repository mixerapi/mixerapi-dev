<?php
declare(strict_types=1);

namespace MixerApi\ExceptionRender;

use Cake\Datasource\EntityInterface;
use Cake\Http\Exception\HttpException;

class ValidationException extends HttpException
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
        parent::__construct(
            $message ?? 'Error saving resource',
            $this->_defaultCode
        );

        $this->entity = $entity;
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
