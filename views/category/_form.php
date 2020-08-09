<?php

use app\assets\AxiosAsset;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */

AxiosAsset::register($this);

$this->registerJs(
    <<< 'JS'
        $('#form_category').on('beforeSubmit', function (e) {
            const action = $(this).attr('action');
            const data = $(this).serialize();
            axios({
                method: 'post',
                headers: {'X-Requested-With': 'XMLHttpRequest'},
                url: action,
                data: data
            }).then(function (response) {
                $.pjax.reload({container: '#update_category'});
                $('#modal').modal('hide');
            }).catch(function (e) { 
                // throw e; 
            });
            return false; // prevent default submit
        });
    JS,
    $this::POS_END
);

?>

<div class="category-form">

    <?php Pjax::begin(['id' => 'update_category']) ?>
    
    <?php $form = ActiveForm::begin([
        'id' => 'form_category',
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end() ?>

</div>
