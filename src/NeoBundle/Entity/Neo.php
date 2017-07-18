<?php

namespace NeoBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="neo")
 * @ORM\Entity(repositoryClass="NeoBundle\Entity\Repository\NeoRepository")
 */
class Neo
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="reference_id", type="bigint", unique=true)
     */
    private $referenceId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="speed", type="decimal", precision=12, scale=21)
     */
    private $speed;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="date")
     *
     * @Serializer\Type("DateTime<'Y-m-d'>")
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_hazardous", type="boolean")
     */
    private $isHazardous;

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | Getters Setters
    |-------------------------------------------------------------------------------------------------------------------
    */

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getReferenceId()
    {
        return $this->referenceId;
    }

    /**
     * @param string $referenceId
     *
     * @return $this
     */
    public function setReferenceId($referenceId)
    {
        $this->referenceId = $referenceId;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @param string $speed
     *
     * @return $this
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     *
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHazardous()
    {
        return $this->isHazardous;
    }

    /**
     * @param bool $isHazardous
     *
     * @return $this
     */
    public function setIsHazardous($isHazardous)
    {
        $this->isHazardous = $isHazardous;

        return $this;
    }
}

