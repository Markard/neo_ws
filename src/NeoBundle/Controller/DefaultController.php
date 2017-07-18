<?php

namespace NeoBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\View\View;

class DefaultController
{
    /**
     * @Get(path="")
     *
     * @return View
     */
    public function defaultAction()
    {
        return View::create(['hello' => 'world']);
    }
}
