<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */

$this->title = Yii::t('app', 'Change Password: {name}', [
    'name' => $model->full_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->usual_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Change Password');

$this->registerJs(
    <<< 'JS'
        function viewPassword() {
            const inputs = $('#employee-password, #employee-password_repeat, #employee-password_new');
            for (var input of inputs) {
                const type = $(input).prop('type');
                if (type === "password")
                    $(input).prop('type', 'text')
                else
                    $(input).prop('type', 'password')
            };
        }
    JS,
    $this::POS_END
)
?>

<div class="row employee-update">
    <div class="col">
        <div class="card card-secondary card-outline">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="employee-form">
                <?php $form = ActiveForm::begin([
                    'enableClientValidation' => false,
                    'enableAjaxValidation' => true,
                    'validationUrl' => Url::to(['validate-password', 'id' => $model->id], )
                ]); ?>
                <div class="card-body">
                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'password_new')->passwordInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" onclick="viewPassword()">
                        <label class="form-check-label"><?= Yii::t('app', 'Show password') ?></label>
                    </div>
                </div>
                <div class="card-footer">
                    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>