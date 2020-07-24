<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EmployeePhone */

$this->title = Yii::t('app', 'Update Employee Phone: {name}', [
    'name' => $model->employee_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employee Phones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->employee_id, 'url' => ['view', 'employee_id' => $model->employee_id, 'phone_id' => $model->phone_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="employee-phone-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
