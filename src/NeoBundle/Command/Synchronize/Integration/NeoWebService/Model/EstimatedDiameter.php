<?php

namespace NeoBundle\Command\Synchronize\Integration\NeoWebService\Model;

class EstimatedDiameter
{
    /**
     * @var EstimatedDiameterInKilometers
     */
    public $inKilometers;

    /**
     * @var EstimatedDiameterInMeters
     */
    public $inMeters;

    /**
     * @var EstimatedDiameterInMiles
     */
    public $inMiles;

    /**
     * @var EstimatedDiameterInFeet
     */
    public $inFeet;

    /**
     * @param EstimatedDiameterInKilometers $inKilometers
     * @param EstimatedDiameterInMeters $inMeters
     * @param EstimatedDiameterInMiles $inMiles
     * @param EstimatedDiameterInFeet $inFeet
     */
    public function __construct(
        EstimatedDiameterInKilometers $inKilometers,
        EstimatedDiameterInMeters $inMeters,
        EstimatedDiameterInMiles $inMiles,
        EstimatedDiameterInFeet $inFeet
    ) {
        $this->inKilometers = $inKilometers;
        $this->inMeters = $inMeters;
        $this->inMiles = $inMiles;
        $this->inFeet = $inFeet;
    }
}
