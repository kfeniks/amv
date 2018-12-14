<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'name' => 'AMV Anime Misic Videos',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language'=>'ru-RU',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => ''
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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

        'assetManager' => [
            'basePath' => '@webroot/assets',
            'baseUrl' => '/frontend/web/assets'
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'medium',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'suffix' => '.html',
            'rules' => [
                '' => 'site/index',
                '<controller>/viewlocal/<id:\d+>' => '<controller>/viewlocal',
                '<controller>/download_local/<id:\d+>' => '<controller>/download_local',
                '<controller>/viewpreview/<id:\d+>' => '<controller>/viewpreview',
                '<controller>/download_preview/<id:\d+>' => '<controller>/download_preview',
                '<controller>/viewdirect/<id:\d+>' => '<controller>/viewdirect',

                '<controller>/<id:\d+>' => '<controller>/view',
                '<controller>/videos_info/<id:\d+>' => '<controller>/videos_info',
                '<controller>/update_videos/<id:\d+>' => '<controller>/update_videos',
                '<action>' => 'site/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:(post|comment)>/<id:\d+>' => '<controller>/view',
               // 'signup' => 'site/signup',
              //  'contact' => 'site/contact',
              //  'about' => 'site/about',
              //  'login' => 'site/login',
               // 'logout' => 'site/logout',
                'reset' => 'site/request-password-reset',
             //   'home' => 'site/home',
                'homefaqs' => 'site/faqs',
             //   'myclips' => 'site/myclips',
              //  '<action>' => 'post/<action>',
//                '<controller>s' => '<controller>/index',
//                '<controller/<id:\d+>' => '<controller>/view',
//                '<controller:\w+>/page/<page:\d+>' => '<controller>/index',
//                '<controller:\w+>' => '<controller>/index',
//                '<controller:\w+>/' => '<controller>/index',
//                '<controller:\w+>/<action:(\w|-)+>/<id:\d+>' => '<controller>/<action>',
//                '<module:\w+>/<controller:\w+>/<action:(\w|-)+>' => '<module>/<controller>/<action>',
//                '<controller:\w+>/<action:(\w|-)+>' => '<controller>/<action>'

            ],
        ],

    ],
    'params' => $params,
];
