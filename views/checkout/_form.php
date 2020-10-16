<?php

use kartik\form\ActiveForm;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

?>
<div class="pos-form card card-primary card-outline">

    <div class="card-header">
        <h3 class="card-title"><?= Yii::t('app', 'Add payments') ?></h3>
    </div>

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validationUrl' => ['/api/pay/validation'],
        'validateOnSubmit' => false,
    ]); ?>

    <div class="card-body">
        <div class="row">
            <?= $form->field($model, 'payment_method_id', ['options' => ['class' => 'col-12']])->widget(Select2::class, [
                'options' => [
                    'placeholder' => Yii::t('app', 'Select payment method'),
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 2,
                    'language' => [
                        'errorLoading' => new JsExpression(
                            "() => { return '" . Yii::t('app', 'Waiting for results...') . "'; }"
                        ),
                    ],
                    'ajax' => [
                        'url' => Url::to(['/api/pay/query']),
                        'dataType' => 'json',
                        'delay' => 100,
                        'data' => new JsExpression('params => { return { q:params.term }; }'),
                        'cache' => true
                    ],
                    'escapeMarkup' => new JsExpression('markup => { return markup; }'),
                    'templateResult' => new JsExpression('payment => { return payment.name; }'),
                    'templateSelection' => new JsExpression('payment => { return payment.name; }'),
                ],
                'pluginEvents' => [
                    'select2:select' => new JsExpression('payment => { 
                        const { installment_limit } = payment.params.data;
                        $("#pay-installments").prop("max", installment_limit);
                        $("#pay-installments").val(1);
                    }'),
                ],
            ]) ?>

            <?= $form->field($model, 'installments', ['options' => ['class' => 'col-12']])
                ->textInput(['type' => 'number', 'value' => 1, 'min' => 1, 'max' => 1]) ?>

            <?= $form->field($model, 'value', [
                'addon' => [
                    'prepend' => [
                        'content' => Yii::$app->formatter->getCurrencySymbol(),
                        'options' => ['class' => 'alert-secondary'],
                    ]
                ],
                'options' => [
                    'class' => 'col-12',
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

            <?= $form->field($model, 'sale_id')->hiddenInput()->label(false); ?>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-end">
            <?= Html::submitButton(Yii::t('app', 'Add Payment'), ['class' => 'btn btn-success', 'v-on:click' => 'pushPay']) ?>
        </div>
    </div>

    <?php $form = ActiveForm::end(); ?>

</div>