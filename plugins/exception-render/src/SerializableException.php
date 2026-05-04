<?php
declare(strict_types=1);

namespace MixerApi\ExceptionRender;

use Cake\Core\Configure;
use JsonSerializable;
use ReflectionClass;
use Throwable;

class SerializableException extends \Exception implements JsonSerializable
{
    private Throwable $wrapped;

    public function __construct(Throwable $exception)
    {
        $this->wrapped = $exception;
        parent::__construct($exception->getMessage(), (int) $exception->getCode());
        $this->file = $exception->getFile();
        $this->line = $exception->getLine();
    }

    public function jsonSerialize(): array
    {
        $data = [
            'class' => (new ReflectionClass($this->wrapped))->getShortName(),
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
        ];

        if (Configure::read('debug')) {
            $data['file'] = $this->getFile();
            $data['line'] = $this->getLine();
        }

        return $data;
    }
}
