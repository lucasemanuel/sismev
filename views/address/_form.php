<?php

use app\assets\AxiosAsset;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Address */
/* @var $form yii\widgets\ActiveForm */

AxiosAsset::register($this);

$this->registerJs(
    <<< 'JS'
        function getZipcode(code) {
            axios.get('/api/address',{
                params: { code: code }
            }).then(function (response) {
                const data = response.data;
                setForm(data);
                delete data['complement'];
                delete data['zip_code'];
                toggleReadOnly(data);
            }).catch(function (error) {
                const data = error.response.data;
                $(document).Toasts('create', {
                    title: data.name,
                    body: data.message,
                    autohide: true,
                    delay: 5000,
                    class: 'bg-warning fix-toast'
                })
            });
        }

        function setForm(data) {
            $('#address-federated_unit').val(data.federated_unit);
            $('#address-city').val(data.city);
            $('#address-neighborhood').val(data.neighborhood);
            $('#address-street').val(data.street);
        }

        function toggleReadOnly(data) {
            Object.keys(data).forEach(function(element) {
                const target =  $('#address-'+element);
                if (target.val() == '')
                    target.prop('readonly', false);
                else if (!target.is('[readonly]'))
                    target.prop('readonly', true);
            })
        }

        $("#address-zip_code").keyup(function(event) {
            const zipcode = event.target.value;
            if (zipcode.length == 8)
                getZipcode(zipcode);
            else
                setForm({ federated_unit: '', city: '', neighborhood: '', street: ''});
        });
    JS,
    $this::POS_END
)

?>

<div class="address-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card-body">
        <?= $form->field($model, 'zip_code')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'federated_unit')->textInput(['maxlength' => true, 'readonly' => true]) ?>

        <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'readonly' => true]) ?>

        <?= $form->field($model, 'neighborhood')->textInput(['maxlength' => true, 'readonly' => true]) ?>

        <?= $form->field($model, 'street')->textInput(['maxlength' => true, 'readonly' => true]) ?>

        <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'complement')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="card-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
