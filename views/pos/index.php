<?php
/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Point of Sale');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col">
        <?= $this->render('_form', [
            'model' => $item
        ]); ?>
    </div>
</div>