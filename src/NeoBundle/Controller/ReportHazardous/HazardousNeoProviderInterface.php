<?php

namespace NeoBundle\Controller\ReportHazardous;

use NeoBundle\Entity\Neo;

interface HazardousNeoProviderInterface
{
    /**
     * @return Neo[]
     */
    public function listHazardousNeo();
}
