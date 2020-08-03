<?php

use app\assets\AxiosAsset;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\widgets\MaskedInput;
use kartik\date\DatePicker;

$this->title = Yii::t('app', 'Sign Up - Your Company');

AxiosAsset::register($this);

$this->registerJs(
    <<< 'JS'
        const form = $('#form_signup');

        form.on('beforeSubmit', function() {
            const data = form.serialize();
            axios({
                method: 'post',
                headers: {'X-Requested-With': 'XMLHttpRequest'},
                url: '/signup/index',
                data: data
            })
            return false; // prevent default submit
        });

        $("#next-button").click(function() {
            const data = form.serialize();
            axios({
                method: 'post',
                headers: {'X-Requested-With': 'XMLHttpRequest'},
                url: '/signup/next',
                data: data
            }).then(function (response) {
                if (Object.keys(response.data).length === 0) { 
                    toggleForm();
                    form.yiiActiveForm("resetForm");
                } else {
                    form.submit();
                }
            })
            return false; // prevent default submit
        });

        function toggleForm() {
            $('.title-company, .fields-company, .actions-company, .title-employee, .fields-employee, .actions-employee').toggleClass('d-none');

            $('label#company-btn, label#employee-btn').toggleClass('btn-primary btn-default');
            $('label#company-btn, label#employee-btn').toggleClass('disabled');
        }

    JS,
    $this::POS_END
);

$this->registerJs(
    <<< 'JS'
        const div = $('div.register-div');
        div.css("padding", "100px 20px");
    JS,
    $this::POS_LOAD
);

$this->registerCss(
    <<< 'CSS'
        .register-box-msg, .btn-group-toggle {
            padding-bottom: 10px;
        }
        .register-box {
            padding: 0 20px;
        }
    CSS
);

?>
<div id="signup">

    <p class="register-box-msg title-company">
        <?= Yii::t('app','Complete the form with your company details.') ?>
    </p>

    <p class="register-box-msg title-employee d-none">
        <?= Yii::t('app','Now, tell me about you.') ?>
    </p>

    <div class="row justify-content-center">
        <div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">
            <label id="company-btn" class="btn btn-primary">
                <input type="radio" name="options" id="option1" autocomplete="off" checked="">
                <?= Yii::t('app', 'Company') ?>
            </label>
            <label id="employee-btn" class="btn btn-default disabled">
                <input type="radio" name="options" id="option2" autocomplete="off">
                <?= Yii::t('app', 'Account') ?>
            </label>
        </div>
    </div>

    <?php $form = ActiveForm::begin([
        'id' => 'form_signup',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'action' => ['/signup/index']
    ]); ?>

    <div class="fields-company row">
        <div class="col-sm-6">
            <?= $form->field($company, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($company, 'trade_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($company, 'ein')->widget(MaskedInput::class, [
                'mask' => ['99.999.999/9999-99'],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($company, 'phone_number')->widget(MaskedInput::class, [
                'mask' => ['(99) 9999-9999', '(99) 99999-9999'],
            ]) ?>
            <?= $form->field($company, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    
    <div class="fields-employee d-none row">
        <div class="col-sm-6">
            <?= $form->field($employee, 'full_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($employee, 'usual_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($employee, 'ssn')->widget(MaskedInput::class, [
                'mask' => ['999.999.999-99'],
            ]) ?>
            <?= $form->field($employee, 'birthday')->widget(DatePicker::class, [
                'type' => DatePicker::TYPE_INPUT,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd/mm/yyyy'
                ]
            ]) ?>    
        </div>
        <div class="col-sm-6">
            <?= $form->field($employee, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($employee, 'phone_number')->widget(MaskedInput::class, [
                'mask' => ['(99) 9999-9999', '(99) 99999-9999'],
            ]) ?>
            <?= $form->field($employee, 'password')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($employee, 'password_repeat')->passwordInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group actions-company">
        <div class="row justify-content-end">
            <div class="col-6">
                <?= Html::submitButton(Yii::t('app', 'Next'), ['class' => 'btn btn-primary btn-block', 'id' => 'next-button']) ?>
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
