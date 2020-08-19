<?php

use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = Yii::t('app', 'Select Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="select-category">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="category-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'category_id')->widget(Select2::class, [
            'data' => $list
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>