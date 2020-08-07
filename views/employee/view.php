<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/detailView.css');

?>
<?= Alert::widget() ?>

<div class="employee-view">

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
                            'full_name',
                            'usual_name',
                            'ssn',
                            'birthday:date',
                            'email:email',
                            'phone_number',
                            [
                                'attribute' => 'address_id',
                                'value' => function ($model) {
                                    return isset($model->address_id)
                                        ? $model->address
                                        : null;
                                }
                            ],
                            'is_manager:boolean',
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
                                'format' => 'boolean',
                                'value' => $model->is_deleted
                            ],
                            'created_at:datetime',
                            'updated_at:datetime',
                            [
                                'visible' => $model->is_deleted,
                                'attribute' => 'deleted_at',
                                'value' => 'deleted_at',
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
                <?= Html::a(Yii::t('app', 'Update Address'), ['update-address', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Change Password'), ['change-password', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
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
