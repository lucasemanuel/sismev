<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pay */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pay-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'installments')->textInput() ?>

    <?= $form->field($model, 'payment_method_id')->textInput() ?>

    <?= $form->field($model, 'sale_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
