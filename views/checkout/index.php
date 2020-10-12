<?php
/* @var $this yii\web\View */

use app\assets\AppAsset;
use app\assets\AxiosAsset;
use app\assets\VueAsset;
use kartik\dialog\Dialog;
use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Checkout');
$this->params['breadcrumbs'][] = $this->title;

AxiosAsset::register($this);
$this->registerJsFile(
    '@web/js/checkout/main.js',
    ['depends' => [AppAsset::class, VueAsset::class]]
);

$this->registerCSS(
    <<< CSS
    a {
        cursor: pointer;
    }
    div .col-sm {
        margin-top: 1.25rem;
    }
    .table-payment th:last-child, .table-payment td:last-child {
        text-align: center;
    }
    CSS
);

Dialog::widget();
?>
<div class="checkout-index row">
    <div class="col-md-4">
        <?= $this->render('_form', [
            'model' => $pay
        ]); ?>
    </div>
    <div class="col-md-8">
        <div class="card card-items">
            <div class="card-header border-0">
                <h3 class="card-title"><?= Yii::t('app', 'Order Items') ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="min-width: 100px"><?= Yii::t('app', 'Product') ?></th>
                            <th><?= Yii::t('app', 'Un. Price') ?></th>
                            <th><?= Yii::t('app', 'Amount') ?></th>
                            <th><?= Yii::t('app', 'Total') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in products" key="id">
                            <td>{{ index +1 }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.unit_price }}</td>
                            <td>{{ item.amount }}</td>
                            <td>{{ item.total }}</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="font-weight-bold text-right"><?= Yii::t('app', 'Total:') ?> {{ totalOrder }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card card-items">
            <div class="card-header border-0">
                <h3 class="card-title"><?= Yii::t('app', 'Payments') ?></h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle table-payment">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?= Yii::t('app', 'Payment') ?></th>
                            <th><?= Yii::t('app', 'Installments') ?></th>
                            <th><?= Yii::t('app', 'Value') ?></th>
                            <th><?= Yii::t('app', 'Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in items" is="payment_items" :key="item.id" :index="index" :name="item.name" :installments="item.installments" :value="item.value"></tr>
                        <tr>
                            <td colspan="5" class="font-weight-bold text-right"><?= Yii::t('app', 'Total paid:') ?> {{ totalPaid }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" style="margin-bottom: 1rem;">
            <div class="col d-flex justify-content-end">
                <?= Html::a(Yii::t('app', 'Cancel Sale'), ['/order/delete', 'id' => $pay->sale->order_id], [
                    'class' => 'btn btn-outline-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this order?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div>
        <a class="small-box bg-info" href=<?= Url::to(['/pos/complete', 'code' => $code]); ?> data-confirm="<?= Yii::t('app', 'Do you want to confirm the sale?') ?>" data-method="post">
            <div class="inner text-center">
                <h3><?= Yii::t('app', 'Complete Sale') ?></h3>
                <p><?= Yii::t('app', 'Confirm your sale now!') ?></p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </a>
    </div>
</div>