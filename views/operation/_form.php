<?php

use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Operation */
?>

<div class="operation-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card-body">

        <?= $form->field($model, 'product_id')->widget(Select2::class, [
            'data' => $products,
            'options' => [
                'placeholder' => Yii::t('app', 'Select Product'),
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]) ?>

        <?= $form->field($model, 'in_out')->dropDownList([
            1 => Yii::t('app', 'Input'),
            0 => Yii::t('app', 'Output'),
        ], ['custom' => true]) ?>

        <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'reason')->textInput(['maxlength' => true]) ?>

    </div>

    <div class="card-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
