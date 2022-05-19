<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Exception;

use Exception;
use Throwable;

class JwtAuthException extends Exception
{
    /**
     * @inheritDoc
     */
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
