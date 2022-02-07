<?php
declare(strict_types=1);

namespace AthenaPixel\Service\Listener;

use AthenaPixel\Entity\DesignPackageAsset;
use AthenaPixel\Model\DesignPackageAsset as DesignPackageAssetModel;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;
use function array_values;

class LoadMetaAssetsListener extends AbstractLoadAssetsListener
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
            $meta = $this -> getRenderer() -> designConfig('meta');
            $this -> getRenderer() -> headMeta()
                -> setCharset($meta -> charset)
                -> setAutoEscape($meta -> autoEscape);
            $assets = $this -> queue(DesignPackageAssetModel ::getAllByMetaDesignPackage(
                $this -> getDesignPackageId()));
            foreach ($assets as $asset) {
                $this -> loadMeta($asset);
            }

            if ($meta -> og_data -> enabled) {
                $usedLocale = $e -> getRouter() -> getLastMatchedLocale();
                $asset = new DesignPackageAsset([
                    'method' => 'set',
                    'content' => 'og:locale',
                    'type' => 'property',
                    'conditional' => $usedLocale
                ]);
                $this -> loadMeta($asset);
                $alternateLocales = array_values($this -> getRenderer() -> config('i18n.language.available') -> toArray());
                foreach ($alternateLocales as $alt) {
                    if ($alt === $usedLocale) continue;
                    $asset = new DesignPackageAsset([
                        'method' => 'set',
                        'content' => 'og:locale:alternate',
                        'type' => 'property',
                        'conditional' => $alt
                    ]);
                    $this -> loadMeta($asset);
                }
                $serverUrl = $this -> getRenderer() -> serverUrl(
                    $meta -> og_data -> include_request_uri_in_site_name);
                $asset = new DesignPackageAsset([
                    'method' => 'set',
                    'content' => 'og:url',
                    'type' => 'property',
                    'conditional' => $serverUrl
                ]);
                $this -> loadMeta($asset);
                $asset = new DesignPackageAsset([
                    'method' => 'set',
                    'content' => 'og:site_name',
                    'type' => 'property',
                    'conditional' => $this -> getRenderer() -> projectConfig('site_name')
                ]);
                $this -> loadMeta($asset);
                $asset = new DesignPackageAsset([
                    'method' => 'set',
                    'content' => 'og:description',
                    'type' => 'property',
                    'conditional' => $this -> getRenderer() -> projectConfig('description')
                ]);
                $this -> loadMeta($asset);
                $companyAddress = $this -> getRenderer() -> companyConfig('address');
                foreach ($companyAddress as $label => $data) {
                    $asset = new DesignPackageAsset([
                        'method' => 'set',
                        'content' => 'og:' . $label,
                        'type' => 'property',
                        'conditional' => $data
                    ]);
                    $this -> loadMeta($asset);
                }
            }
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