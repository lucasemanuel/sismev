<?php

use kartik\dialog\Dialog;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

echo Dialog::widget();

$this->title = "#$model->code";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/detailView.css');

?>

<div class="order-view">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
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
                            'code',
                            [
                                'label' => Yii::t('app', 'Status sale'),
                                'value' => function ($model) {
                                    return $model->sale && $model->sale->is_sold ? Yii::t('app', 'Sold') : Yii::t('app', 'Open');
                                }
                            ],
                            'total_value:currency',
                            [
                                'label' => Yii::t('app', 'Total items'),
                                'format' => 'raw',
                                'value' => Yii::$app->formatter->asAmount($model->getTotalItems()),
                            ],
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
                    <h3 class="card-title"><?= Yii::t('app', 'Items') ?></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div> <!-- /.card-body -->
                <div class="card-body table-responsive p-0">
                    <table id="items" class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 50%"><?= Yii::t('app', 'Product') ?></th>
                                <th style="width: 15%"><?= Yii::t('app', 'Price') ?></th>
                                <th style="width: 15%"><?= Yii::t('app', 'Qty') ?></th>
                                <th style="width: 15%"><?= Yii::t('app', 'Subtotal') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $index = 0 ?>
                            <?php foreach ($model->orderItems as $item) : ?>
                                <?php $index += 1; ?>
                                <tr>
                                    <td><?= $index ?></td>
                                    <td><?= $item->product ?></td>
                                    <td><?= Yii::$app->formatter->asCurrency($item->unit_price) ?></td>
                                    <td><?= Yii::$app->formatter->asAmount($item->amount) ?></td>
                                    <td><?= Yii::$app->formatter->asCurrency($item->total) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
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
            <?php if (!($model->sale && $model->sale->is_sold)) : ?>
                <?= Html::a(Yii::t('app', 'POS'), ['/pos', 'code' => $model->code], ['class' => 'btn btn-success']) ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this order?'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php else : ?>
                <?= Html::a(Yii::t('app', 'Invoice'), ['/sale/invoice', 'id' => $model->sale->id], ['class' => 'btn btn-success']) ?>
            <?php endif ?>
        </p>
    </div>
</div>

</div>