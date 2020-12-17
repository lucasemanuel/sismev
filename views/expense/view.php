<?php

use kartik\dialog\Dialog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Expense */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Expenses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

Dialog::widget();

$this->registerCssFile('@web/css/detailView.css');
$this->registerJsFile('@web/js/modal.js', ['depends' => [yii\web\JqueryAsset::class]]);

?>
<div class="expense-view">
    <div class="row">
        <div class="col-12">
            <?= $this->render('@app/views/layouts/modal.php', ['options' => ['title' => Yii::t('app', 'Expense Pay')]]) ?>

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
                            'description',
                            'is_paid:boolean',
                            [
                                'visible' => $model->is_paid,
                                'attribute' => 'paid_at',
                                'format' => 'date',
                            ],
                            'value:currency',
                            'payday:date'
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
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this expense?'),
                        'method' => 'post',
                    ],
                ]) ?>
                <?php if (!$model->is_paid): ?>
                <?= Html::a(Yii::t('app', 'To Pay'), Url::to(['pay', 'id' => $model->id]), [
                    'class' => 'btn btn-success btn-modal', 
                    'value' => Url::to(['pay', 'id' => $model->id]),
                    'data-toggle' => 'modal'
                ]); ?>
                <?php endif; ?>
            </p>
        </div>
    </div>
</div>