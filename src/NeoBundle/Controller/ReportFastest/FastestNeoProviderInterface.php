<?php

namespace NeoBundle\Controller\ReportFastest;

use NeoBundle\Entity\Neo;

interface FastestNeoProviderInterface
{
    /**
     * @param bool $isHazardous
     *
     * @return Neo|null
     */
    public function getFastestNeo($isHazardous = false);
}
