<?php

namespace app\assets;

use rmrevin\yii\fontawesome\CdnFreeAssetBundle;
use yii\web\AssetBundle;

class SBAdmin extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/sb-admin-2.css',
        'https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i'
    ];

    public $js = [
        'js/sb-admin-2.js',
        'js/jquery.easing.min.js'
    ];

    public $depends = [
        CdnFreeAssetBundle::class,
        AppAsset::class
    ];
}

