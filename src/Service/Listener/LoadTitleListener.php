<?php

namespace AthenaPixel\Service\Listener;

use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;
use function array_reverse;
use function array_walk;

class LoadTitleListener extends AbstractLoadAssetsListener
{

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
            $this -> pushTitleAssets($e);
        }
    }

    private function pushTitleAssets(MvcEvent $e)
    {
        $design = $this -> container -> get('conf') -> facade() -> getDesignConfig('layout.head_title');
        $headTitle = $this -> getRenderer() -> headTitle();
        $headTitle -> setDefaultAttachOrder($design -> default_attach_order);
        $defaultContents = $design -> content -> toArray();
        $func = function ($item) use ($design, $headTitle) {
            if ($design -> prepend_default_head_title_content_first) {
                $headTitle -> prepend($item);
            } else {
                $headTitle -> append($item);
            }
        };
        if ($design -> prepend_default_head_title_content_first) {
            $defaultContents = array_reverse($defaultContents);
        }
        array_walk($defaultContents, $func);
        if ($design -> use_prefix) {
            $headTitle -> setPrefix($design -> prefix);
        }
        if ($design -> use_postfix) {
            $headTitle -> setPostfix($design -> postfix);
        }
        $routeConfig = $this -> getRenderer() -> projectRouteConfig($e -> getRouteMatch()
            -> getMatchedRouteName());
        $headTitle -> append($routeConfig -> title);
        $headTitle -> setSeparator($design -> separator);
        $headTitle -> setAutoEscape($design -> autoEcape);
    }
}