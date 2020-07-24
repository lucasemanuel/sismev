<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Sign Up';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'full_name')->textInput(['autofocus' => true, 'maxlength' => true]) ?>

                <?= $form->field($model, 'usual_name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'ssn')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'birthday')->textInput() ?>

                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
