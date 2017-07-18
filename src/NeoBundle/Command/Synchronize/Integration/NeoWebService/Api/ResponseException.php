<?php

namespace NeoBundle\Command\Synchronize\Integration\NeoWebService\Api;

use RuntimeException;
use Throwable;

/**
 * Thrown in case of empty or malformed response from the API.
 */
class ResponseException extends RuntimeException
{
    public function __construct($message, Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
