<?php

namespace AthenaPixel\Controller;

use AthenaCore\Mvc\Controller\MvcController;
use AthenaPixel\Service\PixelService;

class PixelController extends MvcController
{
    public function pixelService():PixelService
    {
        return $this->invokeService();
    }
}