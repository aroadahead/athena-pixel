<?php

return [
    'version' => '0.0.1',
    'author' => 'jrk',
    'listeners' => [
        ['service' => 'loadJsAssetsListener', 'enabled' => true, 'priority' => 1000],
        ['service' => 'loadCssAssetsListener', 'enabled' => true, 'priority' => 1000],
        ['service' => 'loadMetaAssetsListener', 'enabled' => true, 'priority' => 1000],
        ['service' => 'loadTitleListener', 'enabled' => true, 'priority' => 1000],
        ['service' => 'loadNavigationListener', 'enabled' => true, 'priority' => 1000]
    ],
    'commands' => []
];