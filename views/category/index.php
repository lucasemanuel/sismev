<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(
    <<< 'JS'
        $(function() {
            $('#btn-modal').click(function (e) {
                $('#modal').modal('show')
                    .find('#content-modal')
                    .load($(this).attr('value'));
            });
        });
    JS,
    $this::POS_END
)
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button(Yii::t('app', 'Create Category'), ['value' => Url::to(['create']), 'class' => 'btn btn-success', 'id' => 'btn-modal']) ?>
    </p>

    <?= $this->render('@app/views/layouts/modal.php', ['options' => ['title' => Yii::t('app', 'Category')]]) ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(['id' => 'pjax_categories']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'created_at',
            'updated_at',
            'company_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
