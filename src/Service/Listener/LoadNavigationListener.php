<?php

namespace AthenaPixel\Service\Listener;

use AthenaPixel\Model\Navigation;
use Laminas\Authentication\AuthenticationService;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\Navigation\Service\ConstructedNavigationFactory;
use Poseidon\Poseidon;

class LoadNavigationListener extends AbstractLoadAssetsListener
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
            $navConf = $this -> assembleNavConfig();
            foreach ($navConf as $nav) {
                $nav['router'] = $e -> getRouter();
            }
            $this -> filterLoginLogout($navConf);
            $nav = new ConstructedNavigationFactory($navConf);
            $this -> container -> setFactory('Navigation', $nav);
            $this -> container -> setFactory('navigation', $nav);
        }
    }

    private function buildSubPages(array $elms, int $parentId = 0): array
    {
        $branch = [];
        foreach ($elms as $elm) {
            if ($elm['parentid'] == $parentId) {
                $children = $this -> buildSubPages($elms, $elm['id']);
                if ($children) {
                    $elms['pages'] = $children;
                }
                $branch[] = $elm;
            }
        }
        return $branch;
    }

    private function assembleNavConfig(): array
    {
        $registry = Poseidon ::registry();
        $module = $registry -> fetch('app.route.module');
        $controller = $registry -> fetch('app.route.controller');
        $action = $registry -> fetch('app.route.action');
        $designPackageId = $this -> getDesignPackageId();
        $rowSet = Navigation ::byDesignPackageAndResourceOrDefault($designPackageId, $module, $controller, $action);
        $final = [];
        $subpages = [];
        foreach ($rowSet as $row) {
            if ($row -> getParentid() == 0) {
                $final[$row -> getLabel()] = [
                    'id' => (int)$row -> getId(),
                    'parentid' => (int)$row -> getParentid(),
                    'label' => $row -> getLabel(),
                    'route' => $row -> getRoute(),
                    'title' => $row -> getTitle(),
                    'resource' => $row -> getResource(),
                ];
            }
            $rowArr = $row -> toArray();
            $rowArr['id'] = (int)$rowArr['id'];
            $rowArr['parentid'] = (int)$rowArr['parentid'];
            unset($rowArr['type']);
            $subpages[$row -> getLabel()] = $rowArr;
        }
        foreach ($subpages as $subpage => $data) {
            $children = $this -> buildSubPages($subpages, $data['id']);
            if (count($children)) {
                $final[$subpage]['pages'] = $children;
            }
        }
        return $final;
    }

    private function filterLoginLogout(array &$navConf): void
    {
        if (isset($navConf['login']) && isset($navConf['logout'])) {
            $authService = new AuthenticationService();
            if ($authService -> hasIdentity()) {
                unset($navConf['login']);
            } else {
                unset($navConf['logout']);
            }
        }
    }
}