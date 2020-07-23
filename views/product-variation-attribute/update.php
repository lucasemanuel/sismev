<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductVariationAttribute */

$this->title = Yii::t('app', 'Update Product Variation Attribute: {name}', [
    'name' => $model->product_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Variation Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_id, 'url' => ['view', 'product_id' => $model->product_id, 'variation_attribute_id' => $model->variation_attribute_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="product-variation-attribute-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
