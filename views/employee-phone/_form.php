<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmployeePhone */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-phone-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employee_id')->textInput() ?>

    <?= $form->field($model, 'phone_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
