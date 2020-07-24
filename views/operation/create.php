<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Operation */

$this->title = Yii::t('app', 'Create Operation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Operations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
