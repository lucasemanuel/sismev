<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SaleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sales');
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'attribute' => 'order_id',
        'value' => function ($model) {
            return $model->order->code;
        },
    ],
    [
        'attribute' => 'order_total_value',
        'format' => 'currency',
        'value' => function ($model) {
            return $model->order->total_value;
        },
        'pageSummary' => true,
    ],
    [
        'attribute' => 'amount_paid',
        'format' => 'currency',
        'pageSummary' => true,
    ],
    [
        'label' => Yii::t('app', 'Cashier'),
        'attribute' => 'employee_id',
        'value' => function ($model) {
            return $model->employee->usual_name;
        },
    ],
    'sale_at:datetime',
    [
        'label' => Yii::t('app', 'Status'),
        'attribute' => 'is_sold',
        'format' => 'html',
        'value' => function ($model) {
            if (!$model->is_canceled)
                return '<span class="badge bg-success text-uppercase">' . Yii::t('app', 'Sold') . '</span>';
            return '<span class="badge bg-danger text-uppercase">' . Yii::t('app', 'Canceled') . '</span>';
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{view} {delete}',
        'deleteOptions' => [
            'label' => '<span class="fas fa-times-circle"></span>',
            'data-confirm' => Yii::t('app', 'Are you sure you want to cancel this sale?') . '<br>' . Yii::t('app', 'All transactions made because of this sale will be reversed.'),
            'title' => Yii::t('app', 'Cancel'),
            'aria-label' => Yii::t('app', 'Cancel'),
        ],
        'viewOptions' => [
            'label' => '<span class="fas fa-file-invoice"></span>',
            'title' => Yii::t('app', 'Invoice'),
            'aria-label' => Yii::t('app', 'Invoice'),
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view')
                return Url::to(['invoice', 'id' => $model->id]);
            if ($action === 'delete')
                return Url::to(['canceled', 'id' => $model->id]);
        },
        'visibleButtons' => [
            'delete' => function ($model) { 
                return !$model->is_canceled;
            }
        ],
        'width' => '100px',
    ],
];

?>
<div class="sale-index">
    <div class="row">
        <div class="col">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                'responsive' => true,
                'responsiveWrap' => false,
                'hover' => true,
                'showPageSummary' => true,
                'toolbar' =>  [
                    '{toggleData}',
                ],
                'panel' => [
                    'type' => GridView::TYPE_DEFAULT,
                    'heading' => Html::encode($this->title),
                    'afterOptions' => ['class' => ''],
                ],
            ]); ?>
        </div>
    </div>
</div>