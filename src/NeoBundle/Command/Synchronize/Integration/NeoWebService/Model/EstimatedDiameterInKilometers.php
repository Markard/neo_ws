<?php

namespace NeoBundle\Command\Synchronize\Integration\NeoWebService\Model;

class EstimatedDiameterInKilometers
{
    /**
     * @var float
     */
    public $min;

    /**
     * @var float
     */
    public $max;

    /**
     * @param float $min
     * @param float $max
     */
    public function __construct($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }
}
