<?php

namespace NeoBundle\Command\Synchronize\Integration\NeoWebService;

use Carbon\Carbon;
use NeoBundle\Command\Synchronize\Integration\NeoWebService\Model\NeoResponse;

/**
 * Provides Neo data.
 */
interface NeoProviderInterface
{
    /**
     * @param Carbon $startDate
     * @param Carbon $endDate
     *
     * @return NeoResponse[]
     */
    public function getNeoBetweenDates(Carbon $startDate, Carbon $endDate);
}
