<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
$this->registerCssFile('@web/css/detailView.css');

$this->registerCss(
    <<< 'CSS'
        .image-company {
            margin: auto;
            height: 16rem;
            background-image: linear-gradient(rgba(255, 255, 255, 0.1), #222), url(https://images.unsplash.com/photo-1495314736024-fa5e4b37b979?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1352&q=80);
            margin-bottom: 16px;
        }
        .title-company {
            font-size: 50px;
            color: var(--light);
            margin: 0 1.6rem 1.6rem;
        }
    CSS
);

?>

<?= Alert::widget() ?>

<div class="company-view">

    <div class="row">
        <div class="col-12">
            <div class="card image-company d-flex justify-content-end">
                <h1 class="title-company"><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
    </div>

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
                            'trade_name',
                            'ein',
                            'email:email',
                            'phone_number',
                            [
                                'attribute' => 'address_id',
                                'value' => function ($model) {
                                    return isset($model->address_id)
                                        ? $model->address
                                        : null;
                                }
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

    <?php if (Yii::$app->user->identity->is_manager) : ?>
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <p>
                    <?= Html::a(Yii::t('app', 'Update'), ['update'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'Update Address'), ['update-address'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'Delete'), ['delete'], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>
            </div>
        </div>
    <?php endif; ?>
</div>