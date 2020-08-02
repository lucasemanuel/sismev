<?php

namespace app\assets;

use yii\web\AssetBundle;

class AxiosAsset extends AssetBundle
{
    public $sourcePath = '@npm/axios/dist'; 

    public $js = [
        'axios.min.js'
    ];
}

