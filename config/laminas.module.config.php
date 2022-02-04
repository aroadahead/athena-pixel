<?php
declare(strict_types=1);

use AthenaPixel\Controller\Factory\IndexControllerFactory;
use AthenaPixel\Controller\IndexController;
use AthenaPixel\Service\Listener\Factory\LoadCssAssetsListenerFactory;
use AthenaPixel\Service\Listener\Factory\LoadJsAssetsListenerFactory;

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
            'loadCssAssetsListener' => LoadCssAssetsListenerFactory::class
        ]
    ],
    'translator' => [],
    'view_helpers' => [],
    'router' => [
        'routes' => [
            'pixel.alive' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/pixel/alive',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action' => 'alive',
                    ],
                ],
            ],
        ]
    ]
];