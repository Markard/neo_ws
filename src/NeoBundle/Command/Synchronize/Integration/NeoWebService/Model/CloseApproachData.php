<?php

namespace NeoBundle\Command\Synchronize\Integration\NeoWebService\Model;

use Carbon\Carbon;

class CloseApproachData
{
    /**
     * @var Carbon
     */
    public $closeApproachDate;

    /**
     * @var int
     */
    public $epochDateCloseApproach;

    /**
     * @var string
     */
    public $orbitingBody;

    /**
     * @var RelativeVelocity
     */
    public $relativeVelocity;

    /**
     * @var MissDistance
     */
    public $missDistance;

    /**
     * @param Carbon $closeApproachDate
     * @param int $epochDateCloseApproach
     * @param string $orbitingBody
     * @param RelativeVelocity $relativeVelocity
     * @param MissDistance $missDistance
     */
    public function __construct(
        Carbon $closeApproachDate,
        $epochDateCloseApproach,
        $orbitingBody,
        RelativeVelocity $relativeVelocity,
        MissDistance $missDistance
    ) {
        $this->closeApproachDate = $closeApproachDate;
        $this->epochDateCloseApproach = $epochDateCloseApproach;
        $this->orbitingBody = $orbitingBody;
        $this->relativeVelocity = $relativeVelocity;
        $this->missDistance = $missDistance;
    }
}
