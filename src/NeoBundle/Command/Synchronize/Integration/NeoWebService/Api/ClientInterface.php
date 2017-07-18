<?php

namespace NeoBundle\Command\Synchronize\Integration\NeoWebService\Api;

use Carbon\Carbon;
use NeoBundle\Command\Synchronize\Integration\NeoWebService\Model\NeoResponse;

/**
 * Holds logic of interaction with Profile API.
 */
interface ClientInterface
{
    /**
     * @param Carbon $startDate
     * @param Carbon $endDate
     *
     * @return NeoResponse[]
     *
     * @throws ConnectionException in case of connectivity issues.
     * @throws ResponseException in case of any errors in the response format.
     */
    public function getFeed(Carbon $startDate, Carbon $endDate);
}
