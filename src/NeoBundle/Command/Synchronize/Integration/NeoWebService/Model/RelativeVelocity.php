<?php

namespace NeoBundle\Command\Synchronize\Integration\NeoWebService\Model;

class RelativeVelocity
{
    /**
     * @var string
     */
    public $kilometersPerSecond;

    /**
     * @var string
     */
    public $kilometersPerHour;

    /**
     * @var string
     */
    public $milesPerHour;

    /**
     * @param string $kilometersPerSecond
     * @param string $kilometersPerHour
     * @param string $milesPerHour
     */
    public function __construct($kilometersPerSecond, $kilometersPerHour, $milesPerHour)
    {
        $this->kilometersPerSecond = $kilometersPerSecond;
        $this->kilometersPerHour = $kilometersPerHour;
        $this->milesPerHour = $milesPerHour;
    }
}
