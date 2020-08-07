<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Company */

// $this->title = Yii::t('app', 'Update Company Address');
// $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['index']];
// $this->params['breadcrumbs'][] = Yii::t('app', 'Update Address');

$this->title = Yii::t('app', 'Update Address Employee: {name}', [
    'name' => $model->full_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->usual_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update Address');
?>

<div class="row company-update">
    <div class="col">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <?= $this->render('/address/_form', [
                'model' => $address,
            ]) ?>
        </div>
    </div>
</div>
    