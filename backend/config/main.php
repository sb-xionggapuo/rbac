<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'on beforeRequest' => function($event){
        \yii\base\Event::on(\yii\db\ActiveRecord::class,\yii\db\ActiveRecord::EVENT_AFTER_DELETE,[\common\rbac\log::class,"write"]);
        \yii\base\Event::on(\yii\db\ActiveRecord::class,\yii\db\ActiveRecord::EVENT_AFTER_INSERT,[\common\rbac\log::class,"write"]);
        \yii\base\Event::on(\yii\db\ActiveRecord::class,\yii\db\ActiveRecord::EVENT_AFTER_UPDATE,[\common\rbac\log::class,"write"]);
        \yii\base\Event::on(\common\models\LoginForm::class,\common\models\LoginForm::EVENT_AFTER_LOGIN,[\common\rbac\log::class,"write"]);
    },
    'modules' => [
            'backup' => [
                'class' => \spanjeta\modules\backup\Module::class,
            ],
    ],
    'layout' => 'menu',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing'=> false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];
