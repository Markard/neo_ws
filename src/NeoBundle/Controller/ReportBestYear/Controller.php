<?php

namespace NeoBundle\Controller\ReportBestYear;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\View\View;
use NeoBundle\Controller\Input\HazardousRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface as ValidationErrors;

class Controller
{
    /**
     * @var BestYearProviderInterface
     */
    private $bestYearProvider;

    /**
     * @param BestYearProviderInterface $bestYearProvider
     */
    public function __construct(BestYearProviderInterface $bestYearProvider)
    {
        $this->bestYearProvider = $bestYearProvider;
    }

    /**
     * @Get(path="")
     *
     * @ParamConverter(name="request")
     *
     * @param HazardousRequest $request
     * @param ValidationErrors $validationErrors
     *
     * @return View
     */
    public function getAction(HazardousRequest $request, ValidationErrors $validationErrors)
    {
        if ($validationErrors->count()) {
            return View::create(['errors' => $validationErrors], Response::HTTP_BAD_REQUEST);
        }

        return View::create(
            ['year' => $this->bestYearProvider->getYearWithMostAsteroids($request->hazardous)]
        );
    }
}
