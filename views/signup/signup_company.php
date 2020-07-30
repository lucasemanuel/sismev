<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = Yii::t('app', 'Sign Up - Your Company');

?>
<p class="login-box-msg">
    <?= Yii::t('app','Register your company') ?>
</p>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'trade_name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'ein')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<div class="form-group">
    <div class="row justify-content-end">
        <div class="col-4">
            <?= Html::submitButton(Yii::t('app', 'Next'), ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
