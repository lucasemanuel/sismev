<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VariationSet */

$this->title = Yii::t('app', 'Create Variation Set');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Variation Sets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="variation-set-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'list' => $list
    ]) ?>

</div>
