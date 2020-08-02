<?php

use app\assets\AxiosAsset;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\widgets\MaskedInput;

$this->title = Yii::t('app', 'Sign Up - Your Company');

AxiosAsset::register($this);

$this->registerJs(
    <<< 'JS'
        const form = $('#form_signup');

        $("#next-button").click(function() {
            const data = form.serialize();
            axios({
                method: 'post',
                headers: {'X-Requested-With': 'XMLHttpRequest'},
                url: '/signup/next',
                data: data
            }).then(function (response) {
                toggleForm();
            }).catch(function (e) {});
            return false; // prevent default submit
        });

        function toggleForm() {
            // D-none Company
            $('.title-company').toggleClass('d-none');
            $('.fields-company').toggleClass('d-none');
            $('.actions-company').toggleClass('d-none');

            // D-none Employee
            $('.title-employee').toggleClass('d-none');
            $('.fields-employee').toggleClass('d-none');
            $('.actions-employee').toggleClass('d-none');
        }
    JS,
    $this::POS_END
);

?>
<div id="signup">

    <p class="register-box-msg title-company">
        <?= Yii::t('app','Register your company') ?>
    </p>

    <p class="register-box-msg title-employee d-none">
        <?= Yii::t('app','Register your account') ?>
    </p>


    <?php $form = ActiveForm::begin([
        'id' => 'form_signup',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'action' => ['/signup/index']
    ]); ?>

    <div class="fields-company">
        <?= $form->field($company, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($company, 'trade_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($company, 'ein')->textInput(['maxlength' => true]) ?>
        <?= $form->field($company, 'phone_number')->widget(MaskedInput::class, [
            'mask' => ['(99) 9999-9999', '(99) 99999-9999'],
        ]) ?>
        <?= $form->field($company, 'email')->textInput(['maxlength' => true]) ?>
    </div>
    
    <div class="fields-employee d-none">
        <?= $form->field($employee, 'full_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($employee, 'usual_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($employee, 'ssn')->textInput(['maxlength' => true]) ?>
        <?= $form->field($employee, 'birthday')->textInput() ?>
        <?= $form->field($employee, 'email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($employee, 'password')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($employee, 'password_repeat')->passwordInput(['maxlength' => true]) ?>
    </div>

    <div class="form-group actions-company">
        <div class="row justify-content-end">
            <div class="col-4">
                <?= Html::a(Yii::t('app', 'Next'), ['signup/index'], ['class' => 'btn btn-primary btn-block', 'id' => 'next-button']) ?>
            </div>
        </div>
    </div>

    <div class="form-group actions-employee d-none">
        <div class="row justify-content-between">
            <div class="col-4">
                <a href="#" class="btn btn-secondary btn-block" id="back" onclick="toggleForm()" ><?= Yii::t('app', 'Back') ?></a>
            </div>
            <div class="col-4">
                <?= Html::submitButton(Yii::t('app', 'Register'), ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
