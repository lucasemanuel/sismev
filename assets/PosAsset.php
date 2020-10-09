<?php

namespace app\assets;

use yii\web\AssetBundle;

class PosAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/pos/main.js',
        'js/pos/orderItemsComponent.js'
    ];

    public $depends = [
        AppAsset::class,
        AxiosAsset::class,
        VueAsset::class
    ];
}