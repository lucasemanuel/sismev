<?php

namespace app\assets;

use app\assets\AppAsset;
use rmrevin\yii\fontawesome\CdnFreeAssetBundle;
use yii\web\AssetBundle;

class FontsAsset extends AssetBundle
{
    public $sourcePath = '@npm'; 

    public $css = [
        'source-sans-pro/docs/source-sans-pro.css',
    ];

    public $depends = [
        CdnFreeAssetBundle::class,
    ];
}

