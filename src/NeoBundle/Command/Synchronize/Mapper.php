<?php

namespace NeoBundle\Command\Synchronize;

use NeoBundle\Command\Synchronize\Integration\NeoWebService\Model\NeoResponse;
use NeoBundle\Entity\Neo;

/**
 * Maps from \NeoBundle\Command\Synchronize\Integration\NeoWebService\Model\NeoResponse object to
 * to full \NeoBundle\Entity\Neo object.
 *
 * @see \NeoBundle\Command\Synchronize\Integration\NeoWebService\NeoResponse
 * @see \NeoBundle\Entity\Neo
 */
class Mapper
{
    /**
     * @param NeoResponse $neoResponse
     *
     * @return Neo|null
     */
    public function map(NeoResponse $neoResponse)
    {
        if (!$neoResponse->hasCloseApproachData()) {
            return null;
        }
        $speed = $neoResponse->getFirstCloseApproachData()->relativeVelocity->kilometersPerHour;

        return (new Neo())
            ->setIsHazardous($neoResponse->isPotentiallyHazardousAsteroid)
            ->setName($neoResponse->name)
            ->setReferenceId($neoResponse->neoReferenceId)
            ->setDate($neoResponse->date)
            ->setSpeed($speed);
    }
}
