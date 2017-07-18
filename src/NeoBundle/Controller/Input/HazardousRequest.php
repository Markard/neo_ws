<?php

namespace NeoBundle\Controller\Input;

use Symfony\Component\Validator\Constraints as Assert;

class HazardousRequest
{
    /**
     * @var bool
     *
     * @Assert\Type("boolean")
     */
    public $hazardous;

    /**
     * @param bool $hazardous
     */
    public function __construct($hazardous)
    {
        $this->hazardous = $hazardous;
    }
}
