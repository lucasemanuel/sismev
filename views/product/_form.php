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

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?php
        $variation_sets = VariationSet::findByCategory($model->category);
        foreach ($variation_sets as $variation_set) {
            // $variation = $model->getVariationAttributes()->andWhere(['variation_set_id' => $variation_set->id])->one();
            echo $form->field($model, "variations[$variation_set->name]")->widget(Select2::class, [
                'data' => ArrayHelper::map($variation_set->variationAttributes, 'id', 'name'),
                'theme' => Select2::THEME_KRAJEE_BS4,
                'options' => [
                    // 'value' => is_null($variation) ? null : $variation->id,
                    'placeholder' => Yii::t('app', 'Please select a value.')
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