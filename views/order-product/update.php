<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrderProduct */

$this->title = Yii::t('app', 'Update Order Product: {name}', [
    'name' => $model->order_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Order Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->order_id, 'url' => ['view', 'order_id' => $model->order_id, 'product_id' => $model->product_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="order-product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
