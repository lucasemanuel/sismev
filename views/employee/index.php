<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Employees');
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    'full_name',
    [
        'attribute' => 'ssn',
        'filterType' => MaskedInput::class,
        'filterWidgetOptions' => [
            'mask' => ['999.999.999-99'],
        ],
    ],
    [
        'attribute' => 'birthday',
        'format' => 'date',
        'filterType' => GridView::FILTER_DATE,
        'filterWidgetOptions' => [
            'pluginOptions' => [
                'format' => 'dd/mm/yyyy',
            ]
        ],
    ],
    'email',
    [
        'attribute' => 'phone_number',
        'filterType' => MaskedInput::class,
        'filterWidgetOptions' => [
            'mask' => ['(99) 9999-9999', '(99) 99999-9999'],
        ]
    ],
    [
        'attribute' => 'is_manager',
        'class' => '\kartik\grid\BooleanColumn',
        'trueLabel' => Yii::t('app', 'Yes'),
        'falseLabel' => Yii::t('app', 'No')
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'width' => '100px',
    ],
];
?>
<div class="employee-index row">
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
                        'title' => Yii::t('app', 'Add Employee'),
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
    <p>
</div>