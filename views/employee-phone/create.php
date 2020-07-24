<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EmployeePhone */

$this->title = Yii::t('app', 'Create Employee Phone');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employee Phones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-phone-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
