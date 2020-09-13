<?php

use app\models\Employee;
use kartik\daterange\DateRangePicker;
use kartik\form\ActiveForm;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OperationSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>
<div class="card card-outline card-secondary collapsed-card operation-search">
    <div class="card-header">
        <h3 class="card-title"><?= Yii::t('app', 'Advanced Search') ?></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div> <!-- /.card-body -->
    <div class="card-body">
        <?= $form->field($model, 'in_out')->widget(Select2::class, [
            'options' => [
                'placeholder' => Yii::t('app', 'All'),
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
            'data' => [
                1 => Yii::t('app', 'Input'),
                0 => Yii::t('app', 'Output'),
            ]
        ]) ?>

        <?= $form->field($model, 'product_id')->textInput(['maxlength' => 256]) ?>

        <?= $form->field($model, 'setting_product')->radioList([
            0 => Yii::t('app', 'Product Name'),
            1 => Yii::t('app', 'Product Code'),
        ]) ?>

        <?= $form->field($model, 'reason')->textInput(['maxlength' => 64]) ?>

        <?= $form->field($model, 'amount')->widget(NumberControl::class, [
            'maskedInputOptions' => [
                'allowMinus' => false,
                'rightAlign' => false,
            ],
        ]) ?>

        <?= $form->field($model, 'setting_amount')->radioList([
            0 => Yii::t('app', 'Specific amount'),
            1 => Yii::t('app', 'From amount'),
            2 => Yii::t('app', 'Up to')
        ]) ?>

        <?= $form->field($model, 'range_date')->widget(DateRangePicker::class, [
            'presetDropdown' => true,
            'convertFormat' => true,
            'pluginOptions' => [
                'timePicker' => true,
                'timePickerIncrement' => 5,
                'locale' => ['format' => 'd/m/Y h:i:s']
            ],
            'options' => ['placeholder' => Yii::t('app', 'Select range dates')]
        ]) ?>

        <?= $form->field($model, 'view_operations')->checkboxList([
            'valid' => Yii::t('app', 'Valid operations'),
            'undo' => Yii::t('app', 'Undo operations'),
        ]) ?>

        <?= $form->field($model, 'employee_id')->widget(Select2::class, [
            'data' => ArrayHelper::map(Employee::find()->orderBy('full_name')->asArray()->all(), 'id', 'full_name'),
            'options' => [
                'placeholder' => Yii::t('app', 'All'),
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]) ?>
    </div><!-- /.card-body -->
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