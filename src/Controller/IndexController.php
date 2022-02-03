<?php

declare(strict_types=1);

namespace AthenaPixel\Controller;

use Laminas\View\Model\JsonModel;

class IndexController extends PixelController
{
    public function aliveAction(): JsonModel
    {
        $view = new JsonModel();
        $view -> setVariable('data', ['status' => 'alive']);
        return $view;
    }
}