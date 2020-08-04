<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="card-body">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'trade_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'ein')->widget(MaskedInput::class, [
            'mask' => ['99.999.999/9999-99'],
        ]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="card-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
