<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OperationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Operations');
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    'in_out:InputOrOutput',
    'reason',
    'created_at',
    //'product_id',
    [
        'attribute' => 'product_id',
        'value' => function ($model) {
            return $model->product;
        }
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
        'class' => 'kartik\grid\ActionColumn',
        'width' => '100px',
    ],
];

?>
<div class="operation-index">
    <div class="row">
        <div class="col">            
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>

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
                    // 'headingOptions' => ['class' => ''],
                    // 'footer' => false,
                    'afterOptions' => ['class' => ''],
                ],
            ]); ?>
        </div>
    </div>
</div>
