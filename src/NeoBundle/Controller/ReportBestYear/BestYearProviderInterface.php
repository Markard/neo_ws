<?php

namespace NeoBundle\Controller\ReportBestYear;

interface BestYearProviderInterface
{
    /**
     * @param bool $isHazardous
     *
     * @return string|null
     */
    public function getYearWithMostAsteroids($isHazardous = false);
}
