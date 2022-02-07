<?php

declare(strict_types=1);

namespace AthenaPixel\Controller;

use Laminas\View\Model\JsonModel;

class IndexController extends PixelController
{
    public function aliveAction(): JsonModel
    {
        return new JsonModel(['hello' => $this -> pixelService() -> hello()]);
    }
}