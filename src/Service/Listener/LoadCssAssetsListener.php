<?php
declare(strict_types=1);
namespace AthenaPixel\Service\Listener;

use AthenaPixel\Entity\DesignPackageAsset;
use AthenaPixel\Model\DesignPackageAsset as DesignPackageAssetModel;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\Stdlib\ArrayUtils;
use function array_push;

class LoadCssAssetsListener extends AbstractLoadAssetsListener
{
    use QueueAssetsTrait;

    private array $loadedFiles = [];

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
        $this -> markTriggered();
        if (!$e -> getRequest() -> isXmlHttpRequest()) {
            $this -> pushCssAssets($e);
        }
    }

    protected function loadCssAsset(DesignPackageAsset $asset): string
    {
        $filePath = $this -> getFilePath($asset -> getType(), $asset -> getFile(), static::TYPE_CSS,
            $asset -> getSkinsArgs());
        $media = self::TYPE_SCREEN_PROJECTION;
        $conditional = '';
        if (!is_null($asset -> getConditional())) {
            $conditional = $asset -> getConditional();
        }
        $extra = [];
        if ($asset -> isCrossOriginAnonymous()) {
            $extra = self::CROSSORIGIN_ANONYMOUS;
        }
        if (!is_null($asset -> getExtra())) {
            $extra = ArrayUtils ::merge($extra, $asset -> getExtra());
        }
        if ($asset -> getMethod() === 'append' || $asset -> getMethod() === null) {
            $this -> appendStylesheet($filePath, $media, $conditional, $extra);
        } elseif ($asset -> getMethod() === 'prepend') {
            $this -> prependStylesheet($filePath, $media, $conditional, $extra);
        }
        return $filePath;
    }

    private function pushCssAssets(MvcEvent $e)
    {
        $assets = $this -> queue(DesignPackageAssetModel ::getAllCss(
            $this -> getDesignPackageId()));
        foreach ($assets as $asset) {
            array_push($this -> loadedFiles, $this -> loadCssAsset($asset));
        }
    }
}