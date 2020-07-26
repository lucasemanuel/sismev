<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$title = Yii::t('app', 'Login');

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 col-md-8">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h1 text-gray-900 mb-6 font-weight-bold"><?= Yii::$app->name ?></h1>
                            <h1 class="h5 text-gray-900 mb-4"><?= Yii::t('app', 'Welcome Back!') ?></h1>
                        </div>
                        <?php $form = ActiveForm::begin([]); ?>
                        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>
                        <?= $form->field($model, 'rememberMe')->checkbox() ?>
                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                        <hr>
                        <div class="text-center">
                            <?= Html::a(Yii::t('app', 'Create an Account'), ['signup/index']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>