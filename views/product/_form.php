<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card-body">
        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'unit_price', [
            'addon' => [ 
                'prepend' => [
                    'content' => Yii::$app->formatter->getCurrencySymbol(), 
                    'options' => ['class' => 'alert-secondary'],
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

        <?= $form->field($model, 'max_amount')->widget(NumberControl::class, [
            'maskedInputOptions' => [
                'allowMinus' => false,
                'rightAlign' => false,
            ],
        ]) ?>
        
        <?= $form->field($model, 'min_amount')->widget(NumberControl::class, [
            'maskedInputOptions' => [
                'allowMinus' => false,
                'rightAlign' => false,
            ],
        ]) ?>
    </div>

    <div class="card-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
