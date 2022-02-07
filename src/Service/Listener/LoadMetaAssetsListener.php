<?php
declare(strict_types=1);

namespace AthenaPixel\Service\Listener;

use AthenaPixel\Entity\DesignPackageAsset;
use AthenaPixel\Model\DesignPackageAsset as DesignPackageAssetModel;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;

class LoadMetaAssetsListener extends AbstractLoadAssetsListener
{
    use QueueAssetsTrait;

    /**
     * @inheritDoc
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
//        $this -> attachShared($events, 'Laminas\Mvc\Controller\AbstractController', MvcEvent::EVENT_DISPATCH,
//            [$this, 'assembleAssets'], $priority);
        $this -> attachAs($events, MvcEvent::EVENT_DISPATCH, [$this, 'assembleAssets'], $priority);
    }

    public function assembleAssets(MvcEvent $e): void
    {
        if (!$e -> getRequest() -> isXmlHttpRequest()) {
            $assets = $this -> queue(DesignPackageAssetModel ::getAllByMetaDesignPackage(
                $this -> getDesignPackageId()));
            foreach ($assets as $asset) {
                $this -> loadMeta($asset);
            }

            $designMetaCharsetConfig = $this -> getRenderer() -> designConfig('meta.charset');
            $this -> getRenderer() -> headMeta()
                -> setAutoEscape($designMetaCharsetConfig -> autoEscape)
                -> setCharset($designMetaCharsetConfig -> charset);
        }
    }

    protected function loadMeta(DesignPackageAsset $asset): void
    {
        $method = $asset -> getMethod();
        $func = $method . ucfirst($asset -> getType());
        $this -> getRenderer()
            -> headMeta()
            -> $func($asset -> getContent(), $asset -> getConditional());
    }
}