<?php

use app\models\Category;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Variationearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Variation');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/modal.js', ['depends' => [yii\web\JqueryAsset::class]]);

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    'name',
    [
        'attribute' => 'category_id',
        'value' => function ($model) {
            return $model->category->name;
        },
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => ArrayHelper::map(Category::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => Yii::t('app', 'Select')],
        'group' => true,  // enable grouping
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'width' => '100px',
        'buttons' => [
            'update' => function ($url, $model) {
                return Html::a(
                    '<span class="fas fa-pencil-alt" aria-hidden="true"></span>',
                    $url,
                    ['value' => $url, 'title' => Yii::t('kvgrid', 'Update'), 'class' => 'btn-modal', 'data-toggle' => 'modal']
                );
            }
        ]
    ],
];
?>
<div class="row variation-index">
    <div class="col">
        <?= $this->render('@app/views/layouts/modal.php', ['options' => ['title' => Yii::t('app', 'Variation')]]) ?>

        <?= GridView::widget([
            'id' => 'grid_categories',
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
                        'value' => Url::to(['create']),
                        'class' => 'btn btn-success btn-modal',
                        'title' => Yii::t('app', 'Add Variation'),
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