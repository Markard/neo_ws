<?php

namespace NeoBundle\Command\Synchronize\Integration\NeoWebService\Model;

use Carbon\Carbon;

/**
 * Reflects Near Earth Object structure from NeoWs @see https://api.nasa.gov/neo/
 */
class NeoResponse
{
    /**
     * @var Carbon
     */
    public $date;

    /**
     * @var string
     */
    public $neoReferenceId;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $nasaJplUrl;

    /**
     * @var float
     */
    public $absoluteMagnitudeH;

    /**
     * @var bool
     */
    public $isPotentiallyHazardousAsteroid;

    /**
     * @var EstimatedDiameter
     */
    public $estimatedDiameter;

    /**
     * @var CloseApproachData[]
     */
    private $closeApproachData = [];

    /**
     * @param Carbon $date
     * @param string $neoReferenceId
     * @param string $name
     * @param string $nasaJplUrl
     * @param float $absoluteMagnitudeH
     * @param bool $isPotentiallyHazardousAsteroid
     * @param EstimatedDiameter $estimatedDiameter
     */
    public function __construct(
        Carbon $date,
        $neoReferenceId,
        $name,
        $nasaJplUrl,
        $absoluteMagnitudeH,
        $isPotentiallyHazardousAsteroid,
        EstimatedDiameter $estimatedDiameter
    ) {
        $this->date = $date;
        $this->neoReferenceId = $neoReferenceId;
        $this->name = $name;
        $this->nasaJplUrl = $nasaJplUrl;
        $this->absoluteMagnitudeH = $absoluteMagnitudeH;
        $this->isPotentiallyHazardousAsteroid = $isPotentiallyHazardousAsteroid;
        $this->estimatedDiameter = $estimatedDiameter;
    }

    /**
     * @return CloseApproachData
     */
    public function getFirstCloseApproachData()
    {
        return $this->closeApproachData[0];
    }

    /**
     * @return bool
     */
    public function hasCloseApproachData()
    {
        return count($this->closeApproachData) > 0;
    }

    /**
     * @param CloseApproachData $closeApproachData
     *
     * @return $this
     */
    public function addCloseApproachData(CloseApproachData $closeApproachData)
    {
        $this->closeApproachData[] = $closeApproachData;

        return $this;
    }
}
