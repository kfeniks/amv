<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['gii'],
    'language'=>'ru-RU',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/admin'
        ],
        'assetManager' => [
            'basePath' => '@webroot/assets',
            'baseUrl' => '/backend/web/assets'
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
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                '<action>'=>'site/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:(post|comment)>/<id:\d+>' => '<controller>/view',
                '<controller>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            ],
        ],

    ],
    'params' => $params,
];
