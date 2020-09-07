<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Operation */

$this->title = Yii::t('app', 'Create Operation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Operations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row operation-create">
    <div class="col">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <?= $this->render('_form', [
                'model' => $model,
                'products' => $products
            ]) ?>
        </div>
    </div>
</div>