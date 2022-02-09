<?php
declare(strict_types=1);
namespace AthenaPixel\Service\Listener;

use AthenaPixel\Entity\DesignPackageAsset;
use AthenaPixel\Model\DesignPackageAsset as DesignPackageAssetModel;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\Stdlib\ArrayUtils;
use function array_push;

class LoadJsAssetsListener extends AbstractLoadAssetsListener
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
            $this -> pushJsAssets($e);
        }
    }

    protected function loadJsAsset(DesignPackageAsset $asset): string
    {
        $filePath = $this -> getFilePath($asset -> getType(), $asset -> getFile(), static::TYPE_JS,
            $asset -> getSkinsArgs());
        $extra = [];
        if ($asset -> isCrossOriginAnonymous()) {
            $extra = self::CROSSORIGIN_ANONYMOUS;
        }
        if (!is_null($asset -> getConditional())) {
            $extra['conditional'] = $asset -> getConditional();
        }
        if (!is_null($asset -> getExtra())) {
            $extra = ArrayUtils ::merge($extra, $asset -> getExtra());
        }
        if ($asset -> getMethod() === 'append' || $asset -> getMethod() === null) {
            $this -> appendJsFile($filePath, $extra);
        } elseif ($asset -> getMethod() === 'prepend') {
            $this -> prependJsFile($filePath, $extra);
        }
        return $filePath;
    }

    private function pushJsAssets(MvcEvent $e)
    {
        $assets = $this -> queue(DesignPackageAssetModel ::getAllJs(
            $this -> getDesignPackageId()));
        foreach ($assets as $asset) {
            array_push($this -> loadedFiles, $this -> loadJsAsset($asset));
        }
    }
}