<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = Yii::t('app', 'Login');

?>

<p class="login-box-msg">
    <?= Yii::t('app','Sign in to start your session') ?>
</p>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'email')->textInput() ?>
<?= $form->field($model, 'password')->passwordInput() ?>

<div class="row">
    <div class="col-8">
        <?= $form->field($model, 'rememberMe')->checkbox() ?>
    </div>
    <div class="col-4">
        <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
