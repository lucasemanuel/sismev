<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Employees');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <!-- <?= Html::a(Yii::t('app', 'Create Employee'), ['create'], ['class' => 'btn btn-success']) ?> -->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    echo GridView::widget([
        'dataProvider'=> $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
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
                'class' => 'kartik\grid\ActionColumn',
            ],
        ],
        'hover' => true,
        // 'toolbar' => [
        //     '{export}',
        //     '{toggleData}'
        // ],
        // 'toggleDataContainer' => ['class' => 'btn-group-sm'],
        // 'exportContainer' => ['class' => 'btn-group-sm'],
        'panel' => [
            'heading' => '<h3 class="panel-title">'.Html::encode($this->title).'</h3>',
            'type' => 'default',
            'before'=> Html::a(Yii::t('app', 'Create Employee'), ['create'], ['class' => 'btn btn-success']),
            // 'after'=>Html::a('<i class="fas fa-redo"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
            'footer'=>false
        ],
    ]);
    ?>


</div>
