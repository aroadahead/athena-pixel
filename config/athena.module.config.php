<?php

return [
    'version' => '0.0.1',
    'author' => 'jrk',
    'listeners' => [
        ['service'=>'loadJsAssetsListener','enabled'=>true,'priority'=>1000]
    ],
    'commands' => []
];