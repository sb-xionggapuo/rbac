<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'view' => [
            'renderers' => [
                'tpl' => [
                    'class' => 'yii\smarty\ViewRenderer',
                    //'cachePath' => '@runtime/Smarty/cache',

                ],
            ],
        ],
        'authManager' => [
                'class' => \yii\rbac\DbManager::class ,
        ],
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => '127.0.0.1:9201'],
                ['http_address' => '127.0.0.1:9202'],
                ['http_address' => '127.0.0.1:9203'],
                // configure more hosts if you have a cluster
            ],
            'dslVersion' => 7, // default is 5
        ],
    ],
];
