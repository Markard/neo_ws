<?php


namespace NeoBundle\Command\Synchronize\Integration\NeoWebService\Api;

use Carbon\Carbon;
use InvalidArgumentException;
use NeoBundle\Command\Synchronize\Integration\NeoWebService\Model\CloseApproachData;
use NeoBundle\Command\Synchronize\Integration\NeoWebService\Model\EstimatedDiameter;
use NeoBundle\Command\Synchronize\Integration\NeoWebService\Model\EstimatedDiameterInFeet;
use NeoBundle\Command\Synchronize\Integration\NeoWebService\Model\EstimatedDiameterInKilometers;
use NeoBundle\Command\Synchronize\Integration\NeoWebService\Model\EstimatedDiameterInMeters;
use NeoBundle\Command\Synchronize\Integration\NeoWebService\Model\EstimatedDiameterInMiles;
use NeoBundle\Command\Synchronize\Integration\NeoWebService\Model\MissDistance;
use NeoBundle\Command\Synchronize\Integration\NeoWebService\Model\NeoResponse;
use NeoBundle\Command\Synchronize\Integration\NeoWebService\Model\RelativeVelocity;

/**
 * Maps response data from assoc.array representation to full NeoResponse objects.
 *
 * @see \NeoBundle\Command\Synchronize\Integration\NeoWebService\NeoResponse
 */
class ResponseMapper
{
    /**
     * @param array $responseData
     *
     * @return NeoResponse[]
     */
    public function map(array $responseData)
    {
        $result = [];
        foreach ($responseData as $date => $listOfObjects) {
            if (!$date = $this->getDateAsCarbon($date)) {
                continue;
            }

            foreach ($listOfObjects as $object) {
                if (!$neoResponse = $this->mapArrayToModel($date, $object)) {
                    continue;
                }
                $result[] = $neoResponse;
            }
        }

        return $result;
    }

    /**
     * @param string $date
     *
     * @return Carbon|null
     */
    private function getDateAsCarbon($date)
    {
        try {
            return Carbon::createFromFormat('Y-m-d', $date, 'UTC');
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * Enriches NeoResponse object with data from given array and date.
     *
     * @param Carbon $date
     * @param array $rawData
     *
     * @return NeoResponse|null
     */
    private function mapArrayToModel(Carbon $date, array $rawData)
    {
        if (!isset($rawData['neo_reference_id']) || !is_numeric($rawData['neo_reference_id'])) {
            return null;
        }
        $neoReferenceId = $rawData['neo_reference_id'];

        if (!isset($rawData['name']) || !is_string($rawData['name'])) {
            return null;
        }
        $name = $rawData['name'];

        if (!isset($rawData['nasa_jpl_url']) || !is_string($rawData['nasa_jpl_url'])) {
            return null;
        }
        $nasaJplUrl = $rawData['nasa_jpl_url'];

        if (!isset($rawData['absolute_magnitude_h']) || !is_float($rawData['absolute_magnitude_h'])) {
            return null;
        }
        $absoluteMagnitudeH = $rawData['absolute_magnitude_h'];

        if (!isset($rawData['is_potentially_hazardous_asteroid']) || !is_bool($rawData['is_potentially_hazardous_asteroid'])) {
            return null;
        }
        $isPotentiallyHazardousAsteroid = $rawData['is_potentially_hazardous_asteroid'];

        if (!$estimatedDiameter = $this->mapArrayToEstimatedDiameter($rawData)) {
            return null;
        }

        $neoResponse = new NeoResponse(
            $date,
            $neoReferenceId,
            $name,
            $nasaJplUrl,
            $absoluteMagnitudeH,
            $isPotentiallyHazardousAsteroid,
            $estimatedDiameter
        );

        $this->enrichModelWithCloseApproachData($neoResponse, $rawData);

        return $neoResponse;
    }

    /**
     * @param array $rawData
     *
     * @return EstimatedDiameter|null
     */
    private function mapArrayToEstimatedDiameter(array $rawData)
    {
        if (!isset($rawData['estimated_diameter']['kilometers']['estimated_diameter_min'])
            || !isset($rawData['estimated_diameter']['kilometers']['estimated_diameter_max'])
            || !is_float($rawData['estimated_diameter']['kilometers']['estimated_diameter_min'])
            || !is_float($rawData['estimated_diameter']['kilometers']['estimated_diameter_max'])
        ) {
            return null;
        }
        $inKilometers = new EstimatedDiameterInKilometers(
            $rawData['estimated_diameter']['kilometers']['estimated_diameter_min'],
            $rawData['estimated_diameter']['kilometers']['estimated_diameter_max']
        );

        if (!isset($rawData['estimated_diameter']['meters']['estimated_diameter_min'])
            || !isset($rawData['estimated_diameter']['meters']['estimated_diameter_max'])
            || !is_float($rawData['estimated_diameter']['meters']['estimated_diameter_min'])
            || !is_float($rawData['estimated_diameter']['meters']['estimated_diameter_max'])
        ) {
            return null;
        }
        $inMeters = new EstimatedDiameterInMeters(
            $rawData['estimated_diameter']['meters']['estimated_diameter_min'],
            $rawData['estimated_diameter']['meters']['estimated_diameter_max']
        );

        if (!isset($rawData['estimated_diameter']['miles']['estimated_diameter_min'])
            || !isset($rawData['estimated_diameter']['miles']['estimated_diameter_max'])
            || !is_float($rawData['estimated_diameter']['miles']['estimated_diameter_min'])
            || !is_float($rawData['estimated_diameter']['miles']['estimated_diameter_max'])
        ) {
            return null;
        }
        $inMiles = new EstimatedDiameterInMiles(
            $rawData['estimated_diameter']['miles']['estimated_diameter_min'],
            $rawData['estimated_diameter']['miles']['estimated_diameter_max']
        );

        if (!isset($rawData['estimated_diameter']['feet']['estimated_diameter_min'])
            || !isset($rawData['estimated_diameter']['feet']['estimated_diameter_max'])
            || !is_float($rawData['estimated_diameter']['feet']['estimated_diameter_min'])
            || !is_float($rawData['estimated_diameter']['feet']['estimated_diameter_max'])
        ) {
            return null;
        }
        $inFeet = new EstimatedDiameterInFeet(
            $rawData['estimated_diameter']['feet']['estimated_diameter_min'],
            $rawData['estimated_diameter']['feet']['estimated_diameter_max']
        );

        return new EstimatedDiameter($inKilometers, $inMeters, $inMiles, $inFeet);
    }

    private function enrichModelWithCloseApproachData(NeoResponse $neoResponse, array $rawData)
    {
        if (!isset($rawData['close_approach_data']) || !is_array($rawData['close_approach_data'])) {
            return;
        }

        foreach ($rawData['close_approach_data'] as $rawDatum) {
            if (!$closeApproachData = $this->mapArrayToCloseApproachData($rawDatum)) {
                continue;
            }

            $neoResponse->addCloseApproachData($closeApproachData);
        }
    }

    /**
     * @param array $rawData
     *
     * @return CloseApproachData|null
     */
    private function mapArrayToCloseApproachData(array $rawData)
    {
        if (!isset($rawData['relative_velocity']['kilometers_per_second'])
            || !is_numeric($rawData['relative_velocity']['kilometers_per_second'])
            || !isset($rawData['relative_velocity']['kilometers_per_hour'])
            || !is_numeric($rawData['relative_velocity']['kilometers_per_hour'])
            || !isset($rawData['relative_velocity']['miles_per_hour'])
            || !is_numeric($rawData['relative_velocity']['miles_per_hour'])
        ) {
            return null;
        }
        $relativeVelocity = new RelativeVelocity(
            $rawData['relative_velocity']['kilometers_per_second'],
            $rawData['relative_velocity']['kilometers_per_hour'],
            $rawData['relative_velocity']['miles_per_hour']
        );

        if (!isset($rawData['miss_distance']['astronomical'])
            || !is_numeric($rawData['miss_distance']['astronomical'])
            || !isset($rawData['miss_distance']['lunar'])
            || !is_numeric($rawData['miss_distance']['lunar'])
            || !isset($rawData['miss_distance']['kilometers'])
            || !is_numeric($rawData['miss_distance']['kilometers'])
            || !isset($rawData['miss_distance']['miles'])
            || !is_numeric($rawData['miss_distance']['miles'])
        ) {
            return null;
        }
        $missDistance = new MissDistance(
            $rawData['miss_distance']['astronomical'],
            $rawData['miss_distance']['lunar'],
            $rawData['miss_distance']['kilometers'],
            $rawData['miss_distance']['miles']
        );

        if (!isset($rawData['epoch_date_close_approach']) || !is_integer($rawData['epoch_date_close_approach'])) {
            return null;
        }

        if (!isset($rawData['orbiting_body']) || !is_string($rawData['orbiting_body'])) {
            return null;
        }

        if (!isset($rawData['close_approach_date'])
            || !is_string($rawData['close_approach_date'])
            || !$closeApproachDate = $this->getDateAsCarbon($rawData['close_approach_date'])
        ) {
            return null;
        }

        return new CloseApproachData(
            $closeApproachDate,
            $rawData['epoch_date_close_approach'],
            $rawData['orbiting_body'],
            $relativeVelocity,
            $missDistance
        );
    }
}
