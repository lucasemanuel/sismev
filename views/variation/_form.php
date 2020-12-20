<?php

use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Variation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="variation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if (Yii::$app->controller->action->id != 'update'): ?>

    <?= $form->field($model, 'category_id')->widget(Select2::class, [
        'data' => $list,
    ]) ?>

    <?php endif; ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
