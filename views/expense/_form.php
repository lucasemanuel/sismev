<?php

use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\number\NumberControl;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Expense */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="expense-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card-body">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'value', [
            'addon' => [
                'prepend' => [
                    'content' => Yii::$app->formatter->getCurrencySymbol(),
                    'options' => ['class' => 'secondary'],
                ]
            ]
        ])->widget(NumberControl::class, [
            'maskedInputOptions' => [
                'allowMinus' => false,
                'rightAlign' => false,
            ],
            'displayOptions' => [
                'class' => 'form-control rounded-right'
            ]
        ]) ?>

        <?= $form->field($model, 'payday')->widget(DatePicker::class, [
            'type' => DatePicker::TYPE_INPUT,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy'
            ]
        ]) ?>

        <?php if ($model->paid_at !== null) : ?>
            <?= $form->field($model, 'paid_at')->widget(DatePicker::class, [
                'type' => DatePicker::TYPE_INPUT,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy'
                ]
            ]) ?>
        <?php endif; ?>
    </div>

    <div class="card-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>