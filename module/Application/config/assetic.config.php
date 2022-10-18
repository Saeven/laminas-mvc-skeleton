<?php

declare(strict_types=1);

use Circlical\AsseticBundle\View\NoneStrategy;
use Laminas\View\Renderer\JsonRenderer;

return [
    'buildOnRequest' => true,
    'cacheEnabled' => false,
    'webPath' => realpath('public/assets'),
    'basePath' => 'assets',
    'combine' => true,
    'rendererToStrategy' => [
        JsonRenderer::class => NoneStrategy::class,
    ],

    /*
     * The default assets to load.
     * If the "mixin" option is true, then the listed assets will be merged with any controller / route
     * specific assets. If it is false, the default assets will only be used when no routes or controllers
     * match
     */
    'default' => [
        'assets' => [
            '@base_css',
            '@global_js',
        ],
        'options' => [
            'mixin' => true,
        ],
    ],

    /*
     * In this configuration section, you can define which js, and css resources the module has.
     */
    'modules' => [
        'application' => [
            // module root path for yout css and js files
            'root_path' => __DIR__ . '/../assets',

            // collection of assets
            'collections' => [
                'base_css' => [
                    'assets' => [
                        'css/tailwind-compiled.css',
                        'css/xloader.css',
                    ],
                    'options' => [
                        'output' => 'head_application.css',
                    ],
                ],
                'global_js' => [
                    'assets' => [
                        'js/fetch.utilities.js',
                    ],
                    'options' => [
                        'output' => 'head_global.js',
                    ],
                ],
                'base_images' => [
                    'assets' => [
                        'images/*/*.png',
                        'images/*/*.svg',
                        'images/*/*.jpg',
                        'images/*.png',
                        'images/*.jpg',
                        'images/*.gif',
                        'images/*.jpeg',
                    ],
                    'options' => [
                        'move_raw' => true,
                    ],
                ],
            ],
        ],
    ],
];
