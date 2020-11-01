<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    'code',
    [
        'attribute' => 'total_value',
        'format' => 'currency',
        'pageSummary' => true,
    ],
    [
        'attribute' => 'total_items',
        'value' => function ($model) {
            return (float) $model->getTotalItems();
        },
        'format' => 'amount',
        'pageSummary' => true,
    ],
    'created_at:datetime',
    [
        'label' => Yii::t('app', 'Status'),
        'attribute' => 'status',
        'format' => 'html',
        'value' => function ($model) {
            if ($model->sale && $model->sale->is_sold)
                return '<span class="badge bg-success text-uppercase">' . Yii::t('app', 'Sold') . '</span>';
            return '<span class="badge bg-warning text-uppercase">' . Yii::t('app', 'Open') . '</span>';
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{view} {delete} {update}',
        'width' => '100px',
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'update')
                return Url::to(['/pos', 'code' => $model->code]);
            if ($action === 'delete')
                return Url::to(['delete', 'id' => $model->id]);
            if ($action === 'view')
                return Url::to(['view', 'id' => $model->id]);
        },
        'visibleButtons' => [
            'delete' => function ($model) { 
                return !($model->sale && $model->sale->is_sold);
            },
            'update' => function ($model) { 
                return !($model->sale && $model->sale->is_sold);
            }
        ],
    ],
];

$btn = '';
if (Yii::$app->user->identity->is_manager) {
    $btn =  Html::a(Yii::t('app', 'Clear'), ['clear'], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => Yii::t('app', 'Are you sure you want to delete all empty orders?'),
            'method' => 'post',
        ],
    ]);
}

$this->registerCSS(
    <<< CSS
        .kv-panel-before .btn {
            margin-left: 8px;
        }
    CSS
);

?>
<div class="order-index">
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
                    $btn,
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