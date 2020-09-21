<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentMethodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Payment Methods');
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    'name',
    'installment_limit',
    [
        'attribute' => 'is_deleted',
        'label' => Yii::t('app', 'Active'),
        'value' => function ($model) {
            return !$model->is_deleted;
        },
        'class' => '\kartik\grid\BooleanColumn',
        'falseLabel' => Yii::t('app', 'Yes'),
        'trueLabel' => Yii::t('app', 'No'),
        'width' => '100px',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'width' => '100px',
    ],
];
?>
<div class="payment-method-index">
    <div class="row">
        <div class="col">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'responsive' => true,
                'responsiveWrap' => false,
                'hover' => true,
                'toolbar' =>  [
                    [
                        'content' =>
                            Html::a('<i class="fas fa-plus"></i>', Url::to(['create']), [
                                'class' => 'btn btn-success',
                                'title' => Yii::t('app', 'Add Payment Method'),
                            ]),
                        'options' => ['class' => 'btn-group mr-2']
                    ],
                    '{toggleData}',
                ],
                'panel' => [
                    'type' => GridView::TYPE_DEFAULT,
                    'heading' => Html::encode($this->title),
                    // 'headingOptions' => ['class' => ''],
                    // 'footer' => false,
                    'afterOptions' => ['class' => ''],
                ],
            ]); ?>
        </div>
    </div>
</div>
