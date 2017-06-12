<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/backend/web/bootstrap/css/bootstrap.min.css',
        '/backend/web/dist/css/AdminLTE.min.css',
        '/backend/web/dist/css/skins/_all-skins.min.css',
        '/backend/web/css/styles.css',
    ];
    public $js = [
        '/backend/web/vendors/modernizr-2.6.2-respond-1.1.0.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
