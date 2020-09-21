<?php

use app\models\Employee;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OperationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Operations');
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'attribute' => 'in_out',
        'format' => 'inputOrOutput',
        'filter' => [
            0 => Yii::t('app', 'Output'),
            1 => Yii::t('app', 'Input')
        ],
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => [
                'placeholder' => Yii::t('app', 'All'),
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ],
    ],
    [
        'attribute' => 'product_id',
        'value' => function ($model) {
            return $model->product;
        }
    ],
    'reason',
    [
        'attribute' => 'amount',
        'format' => 'amount',
        'filter' => false
    ],
    [
        'attribute' => 'created_at',
        'format' => 'datetime',
    ],
    [
        'visible' => is_array($searchModel->view_operations) && in_array('undo', $searchModel->view_operations),
        'attribute' => 'deleted_at',
        'format' => 'datetime',
    ],
    [
        'attribute' => 'employee_id',
        'value' => function ($model) {
            return $model->employee->full_name;
        },
        'filter' => ArrayHelper::map(Employee::find()->orderBy('full_name')->asArray()->all(), 'id', 'full_name'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => [
                'placeholder' => Yii::t('app', 'All'),
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ],
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{view} {delete}',
        'deleteOptions' => [
            'label' => '<i class="fas fa-undo-alt"></i>',
            'data-confirm' => Yii::t('app', 'Are you sure you want to undo this operation?')
        ],
        'visibleButtons' => [
            'delete' => function ($model) { 
                return !$model->is_deleted;
            }
        ],
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
