<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/12
 * Time: 下午2:02
 */

return [
    'information' => [
        'rules' => [
            manage\middlewares\EnableCorsMiddleware::class,
            manage\middlewares\BearerTokenAuthMiddleware::class,
        ],
        'controller' => [
            'resource' => [
                'playground'
            ],
        ]
    ],
    'interaction' => [
        'rules' => [
            manage\middlewares\EnableCorsMiddleware::class,
            manage\middlewares\BearerTokenAuthMiddleware::class,
        ],
        'controller' => []
    ],
    'oss' => [
        'rules' => [
            manage\middlewares\EnableCorsMiddleware::class,
            manage\middlewares\BearerTokenAuthMiddleware::class,
        ],
        'controller' => [
            'media' => [
                'callback',
                'wx'
            ],
            'upload' => [
                'wx-token'
            ]
        ]
    ],
    'login' => [
        'rules' => [
            manage\middlewares\EnableCorsMiddleware::class,
        ],
        'controller' => []
    ],
    'send' => [
        'rules' => [
            manage\middlewares\EnableCorsMiddleware::class,
            manage\middlewares\BearerTokenAuthMiddleware::class,
        ],
        'controller' => []
    ],
    'setting' => [

        'rules' => [
            manage\middlewares\EnableCorsMiddleware::class,
            manage\middlewares\BearerTokenAuthMiddleware::class,
        ],
        'controller' => []
    ],

];