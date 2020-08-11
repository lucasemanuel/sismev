<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(
    <<< 'JS'
        $('body').on('click', '.btn-modal', function (e) {
            $('#modal').modal('show')
                .find('#content-modal')
                .load($(this).attr('value'));
        });
    JS,
    $this::POS_END
);

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],

    'name',
    'created_at',
    'updated_at',

    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{update} {delete}',
        'buttons' => [
            'update' => function($url, $model) {
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
<div class="category-index">
    <div class="row">
        <div class="col">
            <?= $this->render('@app/views/layouts/modal.php', ['options' => ['title' => Yii::t('app', 'Category')]]) ?>

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                                'title' => Yii::t('app', 'Add Category'),
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
