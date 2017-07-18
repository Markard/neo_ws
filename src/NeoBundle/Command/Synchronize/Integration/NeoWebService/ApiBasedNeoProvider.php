<?php

namespace NeoBundle\Command\Synchronize\Integration\NeoWebService;

use Carbon\Carbon;
use NeoBundle\Command\Synchronize\Integration\NeoWebService\Api\ClientInterface;
use NeoBundle\Command\Synchronize\Integration\NeoWebService\Model\NeoResponse;

class ApiBasedNeoProvider implements NeoProviderInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param Carbon $startDate
     * @param Carbon $endDate
     *
     * @return NeoResponse[]
     */
    public function getNeoBetweenDates(Carbon $startDate, Carbon $endDate)
    {
        return $this->client->getFeed($startDate, $endDate);
    }
}
