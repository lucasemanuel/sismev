<?php

namespace app\assets;

use yii\web\AssetBundle;

class SaleAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/sale/main.js'
    ];

    public $depends = [];
}