<?php

namespace frontendBook\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web/common';
    public $css      = [
        'css/bootstrap.min.css',
        'css/slick.css',
        'css/slick-theme.css',
        'css/nouislider.min.css',
        'css/font-awesome.min.css',
        'css/style.css',
    ];
    public $js       = [
        'https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js',
        'https://oss.maxcdn.com/respond/1.4.2/respond.min.js',
        'js/jquery.min.js',
        'js/bootstrap.min.js',
        'js/slick.min.js',
        'js/nouislider.min.js',
        'js/jquery.zoom.min.js',
        'js/main.js',
    ];
    public $depends  = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
