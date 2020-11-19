<?php

use app\models\VariationSet;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VariationAttributeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Variation Attributes');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/modal.js', ['depends' => [yii\web\JqueryAsset::class]]);

$listVariationGroup = ArrayHelper::map(VariationSet::find()->orderBy('name')->all(), 'id', 'fullName');

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    'name',
    [
        'attribute' => 'variation_set_id',
        'value' => function ($model) {
            return $model->variationSet->name." ({$model->variationSet->category->name})";
        },
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => $listVariationGroup,
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
<div class="row variation-attribute-index">
    <div class="col">
        <?= $this->render('@app/views/layouts/modal.php', ['options' => ['title' => Yii::t('app', 'Variation Attribute')]]) ?>

        <h1><?= Html::encode($this->title) ?></h1>

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