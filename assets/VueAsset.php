<?php

namespace app\assets;

use yii\web\AssetBundle;

class VueAsset extends AssetBundle
{
    public $sourcePath = '@npm/vue/dist'; 

    public $js = [
        'vue.min.js'
    ];
}

