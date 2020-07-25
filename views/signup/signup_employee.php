<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = Yii::t('app', 'Sign Up - Your Account');

?>
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
            <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h1 text-gray-900 mb-6 font-weight-bold"><?= Yii::$app->name ?></h1>
                            <h1 class="h5 text-gray-900 mb-4"><?= $this->title ?></h1>
                        </div>
                        <?php $form = ActiveForm::begin(); ?>
                        <?= $form->field($model, 'full_name')->textInput(['autofocus' => true, 'maxlength' => true]) ?>
                        <?= $form->field($model, 'usual_name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'ssn')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'birthday')->textInput() ?>
                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <?= Html::a(Yii::t('app', 'Back'), ['signup/step-one'], ['class' => 'btn btn-secondary btn-block']) ?>
                                </div>
                                <div class="col">
                                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary btn-block']) ?>
                                </div>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                        <hr>
                        <div class="text-center">
                            <?= Html::a(Yii::t('app', 'Login'), ['site/login']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>