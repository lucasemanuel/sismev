<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/modal.js', ['depends' => [yii\web\JqueryAsset::class]]);

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    'name',
    [
        'attribute' => 'category_id',
        'value' => function ($model) {
            return $model->category->name;
        }
    ],
    [
        'attribute' => 'unit_price',
        'format' => 'currency',
        'filterType' => GridView::FILTER_NUMBER, 
        'filterWidgetOptions' => [
            'maskedInputOptions' => [
                'prefix' => Yii::$app->formatter->getCurrencySymbol()." ",
                'allowMinus' => false,
                'rightAlign' => false,
            ]
        ],
    ],
    [
        'attribute' => 'amount',
        'format' => 'amount',
        'filterType' => GridView::FILTER_NUMBER, 
        'filterWidgetOptions' => [
            'maskedInputOptions' => [
                'allowMinus' => false,
                'rightAlign' => false,
            ]
        ],
    ],
    [
        'attribute' => 'is_deleted',
        'label' => Yii::t('app', 'Active'),
        'class' => '\kartik\grid\BooleanColumn',
        'trueLabel' => Yii::t('app', 'No'),
        'falseLabel' => Yii::t('app', 'Yes'),
        'value' => function ($model) {
            return !$model->is_deleted;
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'deleteOptions' => [
            'data-confirm' => Yii::t('app', 'Are you sure you want to delete this product?'),
        ],
        'width' => '100px',
    ],
];

?>
<div class="product-index">
    <div class="row">
        <div class="col">
            <?= $this->render('@app/views/layouts/modal.php', ['options' => ['title' => Yii::t('app', 'Category')]]) ?>
            
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
                            Html::button('<i class="fas fa-plus"></i>', [
                                'value' => Url::to(['category']),
                                'class' => 'btn btn-success btn-modal',
                                'title' => Yii::t('app', 'Add Product'),
                            ]),
                        'options' => ['class' => 'btn-group mr-2']
                    ],
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
