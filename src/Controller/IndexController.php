<?php

declare(strict_types=1);

namespace AthenaPixel\Controller;

use Laminas\View\Model\ViewModel;

class IndexController extends PixelController
{
    public function aliveAction(): ViewModel
    {
        $this->getEvent()->getViewModel()->setTerminal(true);
        return new ViewModel(['data' => ['status' => 'alive']]);
    }
}