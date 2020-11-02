<?php

use kartik\daterange\DateRangePicker;
use kartik\form\ActiveForm;
use kartik\number\NumberControl;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>

<div class="card card-outline card-secondary collapsed-card order-search">
    <div class="card-header">
        <h3 class="card-title"><?= Yii::t('app', 'Advanced Search') ?></h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <?= $form->field($model, 'code')->textInput(['maxlength' => 64]) ?>

        <?= $form->field($model, 'created_at')->widget(DateRangePicker::class, [
            'presetDropdown' => true,
            'convertFormat' => true,
            'pluginOptions' => [
                'timePicker' => true,
                'timePickerIncrement' => 5,
                'locale' => ['format' => 'd/m/Y h:i:s A']
            ],
            'options' => ['placeholder' => Yii::t('app', 'Select range dates')]
        ]) ?>

        <?= $form->field($model, 'total_value', [
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

        <?= $form->field($model, 'setting_search_total_value')->radioList([
            0 => Yii::t('app', 'Specific amount'),
            1 => Yii::t('app', 'From amount'),
            2 => Yii::t('app', 'Up to')
        ]) ?>

        <?= $form->field($model, 'total_items', [
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

        <?= $form->field($model, 'setting_search_total_items')->radioList([
            0 => Yii::t('app', 'Specific amount'),
            1 => Yii::t('app', 'From amount'),
            2 => Yii::t('app', 'Up to')
        ]) ?>

        <?= $form->field($model, 'status')->checkboxList([
            'sold' => Yii::t('app', 'Sold'),
            'open' => Yii::t('app', 'Open'),
        ])->label(Yii::t('app', 'Sale status')) ?>

    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col">
                <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
            </div>
            <div class="col d-flex justify-content-end">
                <?= Html::a('Reset', ['index'], ['class' => 'btn btn-outline-secondary align-self-end']) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>