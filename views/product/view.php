<?php

use kartik\dialog\Dialog;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/detailView.css');

echo Dialog::widget();

?>
<div class="product-view">
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
                                'attribute' => 'category_id',
                                'value' => $model->category->name
                            ],
                            [
                                'label' => Yii::t('app', 'Variations'),
                                'value' => function ($model) {
                                    $variations = [];
                                    foreach ($model->variationAttributes as $variation)
                                        array_push($variations, $variation->name);

                                    return implode(", ", $variations);
                                }
                            ],
                            'unit_price:currency',
                            'amount:amount',
                            'max_amount:amount',
                            'min_amount:amount',
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
                            [
                                'attribute' => 'is_deleted',
                                'format' => 'active',
                            ],
                            'created_at:datetime',
                            'updated_at:datetime',
                            [
                                'visible' => $model->is_deleted,
                                'attribute' => 'deleted_at',
                                'format' => 'datetime',
                            ],
                        ],
                    ]) ?>
                </div><!-- /.card-body -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 d-flex justify-content-end">
            <p>
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?php if (!$model->is_deleted) : ?>
                    <?= Html::a(Yii::t('app', 'Disable'), ['soft-delete', 'id' => $model->id], [
                        'class' => 'btn btn-warning',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to disable this product?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php elseif ($model->is_deleted) : ?>
                    <?= Html::a(Yii::t('app', 'Enable'), ['restore', 'id' => $model->id], [
                        'class' => 'btn btn-success',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to enable this product?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php endif; ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this product?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
    </div>
</div>