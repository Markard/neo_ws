<?php

namespace NeoBundle\Command\Synchronize\Integration\NeoWebService\Api;

use RuntimeException;
use Throwable;

/**
 * Thrown in case of connectivity issues - timeouts, DNS errors, wrong redirects etc.
 */
class ConnectionException extends RuntimeException
{
    public function __construct(Throwable $reason)
    {
        parent::__construct($reason->getMessage(), 0, $reason);
    }
}
