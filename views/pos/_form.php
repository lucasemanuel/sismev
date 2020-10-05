<?php

use app\models\Product;
use kartik\form\ActiveForm;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

?>
<div class="pos-form card card-primary card-outline">

    <div class="card-header">
        <h3 class="card-title"><?= Yii::t('app', 'Add order item') ?></h3>
    </div>

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validationUrl' => ['/api/order-item/validation'],
    ]); ?>

    <div class="card-body">
        <div class="row">
            <?= $form->field($model, 'product_id', ['options' => ['class' => 'col']])->widget(Select2::class, [
                'options' => [
                    'placeholder' => Yii::t('app', 'Search for a Product...'),
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 1,
                    'language' => [
                        'errorLoading' => new JsExpression(
                            "() => { return '" . Yii::t('app', 'Waiting for results...') . "'; }"
                        ),
                    ],
                    'ajax' => [
                        'url' => Url::to(['/api/product/query']),
                        'dataType' => 'json',
                        'delay' => 100,
                        'data' => new JsExpression('params => { return { q:params.term }; }'),
                        'cache' => true
                    ],
                    'escapeMarkup' => new JsExpression('markup => { return markup; }'),
                    'templateResult' => new JsExpression('product => { return product.name; }'),
                    'templateSelection' => new JsExpression('product => { return product.name; }'),
                ],
                'pluginEvents' => [
                    'select2:select' => new JsExpression('product => { 
                        const { unit_price } = product.params.data;
                        setPrice(unit_price);
                    }'),
                ],
            ])->label(Yii::t('app', 'Product unit defautl value')) ?>
        </div>

        <div class="row">
            <?= $form->field(new Product(), 'unit_price', [
                'addon' => [
                    'prepend' => [
                        'content' => Yii::$app->formatter->getCurrencySymbol(),
                        'options' => ['class' => 'alert-secondary'],
                    ]
                ],
                'options' => [
                    'class' => 'col-4',
                ]
            ])->widget(NumberControl::class, [
                'disabled' => true,
                'maskedInputOptions' => [
                    'allowMinus' => false,
                    'rightAlign' => false,
                ],
                'displayOptions' => [
                    'class' => 'form-control rounded-right'
                ]
            ])->label(Yii::t('app', 'Product unit defautl value')) ?>

            <?= $form->field($model, 'unit_price', [
                'addon' => [
                    'prepend' => [
                        'content' => Yii::$app->formatter->getCurrencySymbol(),
                        'options' => ['class' => 'alert-secondary'],
                    ]
                ],
                'options' => [
                    'class' => 'col-4'
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

            <?= $form->field($model, 'amount', [
                'options' => [
                    'class' => 'col-4'
                ]
            ])->widget(NumberControl::class, [
                'maskedInputOptions' => [
                    'allowMinus' => false,
                    'rightAlign' => false,
                ],
            ]) ?>

            <?= $form->field($model, 'order_id')->hiddenInput()->label(false);?>
        </div>
    </div>
    <div class="card-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'v-on:click' => 'pushItem']) ?>
    </div>

    <?php $form = ActiveForm::end(); ?>

</div>