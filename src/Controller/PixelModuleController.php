<?php
declare(strict_types=1);
namespace AthenaPixel\Controller;

use Application\Controller\ModuleController;
use AthenaPixel\Service\PixelService;

class PixelModuleController extends ModuleController
{
    public function pixelService():PixelService
    {
        return $this->invokeService();
    }
}