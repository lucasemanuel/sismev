<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VariationAttribute */

$this->title = Yii::t('app', 'Create Variation Attribute');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Variation Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="variation-attribute-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
