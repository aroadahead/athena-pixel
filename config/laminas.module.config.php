<?php
declare(strict_types=1);

use AthenaPixel\Controller\Factory\IndexControllerFactory;
use AthenaPixel\Controller\IndexController;
use AthenaPixel\Service\Factory\PixelServiceFactory;
use AthenaPixel\Service\Listener\Factory\LoadCssAssetsListenerFactory;
use AthenaPixel\Service\Listener\Factory\LoadJsAssetsListenerFactory;
use AthenaPixel\Service\Listener\Factory\LoadMetaAssetsListenerFactory;
use AthenaPixel\Service\Listener\Factory\LoadNavigationListenerFactory;
use AthenaPixel\Service\Listener\Factory\LoadTitleListenerFactory;
use Laminas\Router\Http\Literal;
use Poseidon\Poseidon;

$lamins = Poseidon ::getCore() -> getLaminasManager();
return [
    'view_manager' => [
        'template_map' => [],
        'template_path_stack' => [
            __DIR__ . '/../view'
        ]
    ],
    'controllers' => [
        'factories' => [
            IndexController::class => IndexControllerFactory::class
        ]
    ],
    'service_manager' => [
        'factories' => [
            'loadJsAssetsListener' => LoadJsAssetsListenerFactory::class,
            'loadCssAssetsListener' => LoadCssAssetsListenerFactory::class,
            'loadMetaAssetsListener' => LoadMetaAssetsListenerFactory::class,
            'module.service.athena-pixel' => PixelServiceFactory::class,
            'loadTitleListener' => LoadTitleListenerFactory::class,
            'loadNavigationListener' => LoadNavigationListenerFactory::class
        ]
    ],
    'translator' => [],
    'view_helpers' => [],
    'router' => [
        'routes' => [
            'pixel.alive' => [
                'type' => Literal::class,
                'options' => [
                    'route' => $lamins -> route('alive', 'pixel'),
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action' => 'alive',
                    ],
                ],
            ],
        ]
    ]
];