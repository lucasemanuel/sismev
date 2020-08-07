<?php

use kartik\date\DatePicker;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card-body">
        <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'usual_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'ssn')->widget(MaskedInput::class, [
            'mask' => ['999.999.999-99'],
        ]) ?>

        <?= $form->field($model, 'birthday')->widget(DatePicker::class, [
            'type' => DatePicker::TYPE_INPUT,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd/mm/yyyy'
            ]
        ]) ?>  

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'phone_number')->widget(MaskedInput::class, [
            'mask' => ['(99) 9999-9999', '(99) 99999-9999'],
        ]) ?>

        <?= $form->field($model, 'is_manager')->radioList([0 => Yii::t('app', 'Cashier'), 1 => Yii::t('app', 'Manager')]) ?>
        
        <?php if (Yii::$app->controller->action->id != 'update'): ?>
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>
        <?php endif; ?>
    </div>

    <div class="card-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
