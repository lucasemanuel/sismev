<?php

use app\models\VariationSet;
use kartik\form\ActiveForm;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card-body">
        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'name')->widget(Select2::class, [
            'data' => ArrayHelper::map($model::find()->all(), 'name', 'name'),
            'options' => [
                'placeholder' => '',
                'value' => $model->name,
            ],
            'pluginOptions' => [
                'tags' => true,
                'allowClear' => true,
            ],
        ]) ?>

        <?php
        $variation_sets = VariationSet::findByCategory($model->category->id);
        foreach ($variation_sets as $variation_set) {
            echo $form->field($model, "variations[$variation_set->id]")->widget(Select2::class, [
                'data' => ArrayHelper::map($variation_set->variationAttributes, 'id', 'name'),
                'options' => [
                    'placeholder' => Yii::t('app', 'Select')
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label($variation_set->name);
        }
        ?>

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