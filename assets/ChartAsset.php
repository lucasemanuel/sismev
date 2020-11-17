<?php

namespace app\assets;

use yii\web\AssetBundle;

class ChartAsset extends AssetBundle
{
    public $sourcePath = '@npm/chart.js/dist'; 

    public $js = [
        'Chart.min.js'
    ];
}

