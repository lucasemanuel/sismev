<?php
/* @var $this yii\web\View */

use app\assets\AxiosAsset;
use app\assets\VueAsset;

$this->title = Yii::t('app', 'Point of Sale');
$this->params['breadcrumbs'][] = $this->title;

AxiosAsset::register($this);
$this->registerJsFile('@web/js/pos/main.js',
    ['depends' => [VueAsset::class]]
);

?>
<div class="pos-index row">
    <div class="col">
        <?= $this->render('_form', [
            'model' => $item
        ]); ?>
    </div>
</div>