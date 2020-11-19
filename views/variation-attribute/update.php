<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VariationAttribute */

$this->title = Yii::t('app', 'Update Variation Attribute: {name} ({variation_set})', [
    'name' => $model->name,
    'variation_set' => $model->variationSet->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Variation Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="variation-attribute-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
