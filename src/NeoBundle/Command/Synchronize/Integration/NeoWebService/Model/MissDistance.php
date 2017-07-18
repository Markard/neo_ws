<?php

namespace NeoBundle\Command\Synchronize\Integration\NeoWebService\Model;

class MissDistance
{
    /**
     * @var string
     */
    public $astronomical;

    /**
     * @var string
     */
    public $lunar;

    /**
     * @var string
     */
    public $kilometers;

    /**
     * @var string
     */
    public $miles;

    /**
     * @param string $astronomical
     * @param string $lunar
     * @param string $kilometers
     * @param string $miles
     */
    public function __construct($astronomical, $lunar, $kilometers, $miles)
    {
        $this->astronomical = $astronomical;
        $this->lunar = $lunar;
        $this->kilometers = $kilometers;
        $this->miles = $miles;
    }
}
