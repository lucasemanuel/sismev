<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = Yii::t('app', 'Sign Up - Your Account');

?>
<p class="login-box-msg">
    <?= Yii::t('app','Register your account') ?>
</p>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'usual_name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'ssn')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'birthday')->textInput() ?>
<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
<?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

<div class="form-group">
    <div class="row justify-content-between">
        <div class="col-4">
            <?= Html::a(Yii::t('app', 'Back'), ['signup/step-one'], ['class' => 'btn btn-secondary btn-block']) ?>
        </div>
        <div class="col-4">
            <?= Html::submitButton(Yii::t('app', 'Register'), ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
