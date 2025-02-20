<?php

return [
    'name' => 'Matka App',
    'manifest' => [
        'name' => env('APP_NAME', 'Matka App'),
        'short_name' => 'Matka',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation'=> 'any',
        'status_bar'=> 'black',
        'icons' => [
            '72x72' => [
                'path' => '..\themeAssets\img\matka\matka.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '..\themeAssets\img\matka\matka.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '..\themeAssets\img\matka\matka.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '..\themeAssets\img\matka\matka.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '..\themeAssets\img\matka\matka.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '..\themeAssets\img\matka\matka.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '..\themeAssets\img\matka\matka.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '..\themeAssets\img\matka\matka.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '..\themeAssets\img\matka\matka.png',
            '750x1334' => '..\themeAssets\img\matka\matka.png',
            '828x1792' => '..\themeAssets\img\matka\matka.png',
            '1125x2436' => '..\themeAssets\img\matka\matka.png',
            '1242x2208' => '..\themeAssets\img\matka\matka.png',
            '1242x2688' => '..\themeAssets\img\matka\matka.png',
            '1536x2048' => '..\themeAssets\img\matka\matka.png',
            '1668x2224' => '..\themeAssets\img\matka\matka.png',
            '1668x2388' => '..\themeAssets\img\matka\matka.png',
            '2048x2732' => '..\themeAssets\img\matka\matka.png',
        ],
        'shortcuts' => [
            [
                'name' => 'Shortcut Link 1',
                'description' => 'Shortcut Link 1 Description',
                'url' => '/shortcutlink1',
                'icons' => [
                    "src" => "..\themeAssets\img\matka\matka.png",
                    "purpose" => "any"
                ]
            ],
            [
                'name' => 'Shortcut Link 2',
                'description' => 'Shortcut Link 2 Description',
                'url' => '/shortcutlink2'
            ]
        ],
        'custom' => []
    ]
];
