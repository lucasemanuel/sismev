<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VariationAttribute */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Variation Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/detailView.css');
$this->registerJsFile('@web/js/modal.js', ['depends' => [yii\web\JqueryAsset::class]]);?>

<div class="variation-attribute-view">
    <?= $this->render('@app/views/layouts/modal.php', ['options' => ['title' => Yii::t('app', 'Variation Set')]]) ?>

    <div class="row">
        <div class="col-12">
            <div class="card card-outline">
                <div class="card-header border-0">
                    <h3 class="card-title"><?= Yii::t('app', 'General Data') ?></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div> <!-- /.card-body -->
                <div class="card-body table-responsive p-0">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'name',
                            [
                                'attribute' => 'variationSet.name',
                                'label' => Yii::t('app', 'Variation')
                            ],
                            [
                                'attribute' => 'variationSet.category.name',
                                'label' => Yii::t('app', 'Category')
                            ]
                        ],
                    ]) ?>
                </div><!-- /.card-body -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-outline">
                <div class="card-header border-0">
                    <h3 class="card-title"><?= Yii::t('app', 'System Data') ?></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div> <!-- /.card-body -->
                <div class="card-body table-responsive p-0">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'created_at:datetime',
                            'updated_at:datetime',
                        ],
                    ]) ?>
                </div><!-- /.card-body -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 d-flex justify-content-end">
            <p>
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['value' => Url::to(['update', 'id' => $model->id]), 'class' => 'btn btn-primary btn-modal', 'data-toggle' => 'modal']) ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this employee?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
    </div>
</div>