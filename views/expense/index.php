<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExpenseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Expenses');
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    'name',
    'description:ntext',
    [
        'attribute' => 'value',
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
        'attribute' => 'payday',
        'format' => 'date',
        'filterType' => GridView::FILTER_DATE,
        'filterWidgetOptions' => [
            'pluginOptions' => [
                'format' => 'dd/mm/yyyy',
            ]
        ],
    ],
    [
        'attribute' => 'paid_at',
        'format' => 'date',
        'filterType' => GridView::FILTER_DATE,
        'filterWidgetOptions' => [
            'pluginOptions' => [
                'format' => 'dd/mm/yyyy',
            ]
        ],
    ],
    [
        'attribute' => 'is_paid',
        'class' => '\kartik\grid\BooleanColumn',
        'trueLabel' => Yii::t('app', 'Yes'),
        'falseLabel' => Yii::t('app', 'No'),
        'width' => '100px'
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'width' => '100px',
    ],
];

?>
<div class="expense-index">
    <div class="row">
        <div class="col">            
            <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

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
                            Html::a('<i class="fas fa-plus"></i>', Url::to(['create']),[
                                'class' => 'btn btn-success',
                                'title' => Yii::t('app', 'Add Operation'),
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
