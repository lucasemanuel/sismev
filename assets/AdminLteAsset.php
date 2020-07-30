<?php

namespace app\assets;

use app\assets\AppAsset;
use rmrevin\yii\fontawesome\CdnFreeAssetBundle;
use yii\web\AssetBundle;

class AdminLteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'adminLte/dist/css/adminlte.min.css',
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback'
    ];

    public $js = [
        'adminLte/dist/js/adminlte.js',
    ];

    public $depends = [
        AppAsset::class,
        CdnFreeAssetBundle::class,
    ];
}

