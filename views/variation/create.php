<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Variation */

$this->title = Yii::t('app', 'Create Variation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Variations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="variation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'list' => $list
    ]) ?>

</div>
