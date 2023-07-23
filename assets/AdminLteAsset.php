<?php

namespace app\assets;

use app\assets\AppAsset;
use app\assets\FontsAsset;
use yii\web\AssetBundle;

class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';

    public $css = [
        ['css/adminlte.min.css', 'media' => 'all'],
    ];

    public $js = [
        'js/adminlte.min.js',
    ];

    public $depends = [
        AppAsset::class,
        FontsAsset::class
    ];
}

