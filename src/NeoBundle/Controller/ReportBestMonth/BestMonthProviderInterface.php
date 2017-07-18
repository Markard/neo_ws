<?php

namespace NeoBundle\Controller\ReportBestMonth;

interface BestMonthProviderInterface
{
    /**
     * @param bool $isHazardous
     *
     * @return string|null
     */
    public function getMonthWithMostAsteroids($isHazardous = false);
}
