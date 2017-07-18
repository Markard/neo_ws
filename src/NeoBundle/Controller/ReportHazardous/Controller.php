<?php

namespace NeoBundle\Controller\ReportHazardous;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\View\View;

class Controller
{
    /**
     * @var HazardousNeoProviderInterface
     */
    private $hazardousNeoProvider;

    /**
     * @param HazardousNeoProviderInterface $hazardousNeoProvider
     */
    public function __construct(HazardousNeoProviderInterface $hazardousNeoProvider)
    {
        $this->hazardousNeoProvider = $hazardousNeoProvider;
    }

    /**
     * @Get(path="")
     *
     * @return View
     */
    public function getAction()
    {
        return View::create($this->hazardousNeoProvider->listHazardousNeo());
    }
}
