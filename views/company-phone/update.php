<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CompanyPhone */

$this->title = Yii::t('app', 'Update Company Phone: {name}', [
    'name' => $model->company_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Company Phones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->company_id, 'url' => ['view', 'company_id' => $model->company_id, 'phone_id' => $model->phone_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="company-phone-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
