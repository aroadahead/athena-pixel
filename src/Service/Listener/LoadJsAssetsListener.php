<?php

namespace AthenaPixel\Service\Listener;

use AthenaCore\Mvc\Service\Listener\AbstractServiceListener;
use AthenaPixel\Model\DesignPackageAsset;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;
use function var_dump;

class LoadJsAssetsListener extends AbstractServiceListener
{
    use QueueAssetsTrait;

    /**
     * @inheritDoc
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this -> attachShared($events, 'Laminas\Mvc\Controller\AbstractController', MvcEvent::EVENT_DISPATCH,
            [$this, 'assembleAssets'], $priority);
    }

    public function assembleAssets(MvcEvent $e): void
    {
        if (!$e -> getRequest() -> isXmlHttpRequest()) {
            $assets = $this -> queue(DesignPackageAsset ::getAllByJsDesignPackage(1));
            var_dump($assets);
        }
    }
}