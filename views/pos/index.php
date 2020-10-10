<?php
/* @var $this yii\web\View */

use app\assets\PosAsset;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Point of Sale');
$this->params['breadcrumbs'][] = $this->title;

PosAsset::register($this);

$this->registerCSS(
    <<< CSS
    a {
        cursor: pointer;
    }
    div .col-sm {
        margin-top: 1.25rem;
    }
    th:last-child, td:last-child {
        text-align: center;
    }
    CSS
);

?>
<div class="pos-index row">
    <div class="col">
        <?= $this->render('_form', [
            'model' => $item
        ]); ?>
        <div class="card card-items">
            <div class="card-header border-0">
                <h3 class="card-title"><?= Yii::t('app', 'Order Items') ?></h3>
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
                            <th><?= Yii::t('app', 'Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in items" is="order_items" :key="item.id" :index="index" :name="item.name" :amount="item.amount" :unit_price="item.unit_price" :total="item.total"></tr>
                        <tr>
                            <td colspan="6" class="font-weight-bold text-right"><?= Yii::t('app', 'Total:') ?> {{total}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <a class="small-box bg-info" href=<?= Url::to(['checkout', 'code' => $code]) ?>>
            <div class="inner text-center">
                <h3><?= Yii::t('app', 'Checkout') ?></h3>
                <p><?= Yii::t('app', 'Choose payment methods') ?></p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </a>
    </div>
</div>