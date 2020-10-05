<?php
/* @var $this yii\web\View */

use app\assets\AppAsset;
use app\assets\AxiosAsset;
use app\assets\VueAsset;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Point of Sale');
$this->params['breadcrumbs'][] = $this->title;

AxiosAsset::register($this);
$this->registerJsFile(
    '@web/js/pos/main.js',
    ['depends' => [AppAsset::class, VueAsset::class]]
);

$this->registerCSS(
    <<< CSS
    a {
        cursor: pointer;
    }
    CSS
)

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
                            <th>Product</th>
                            <th>Price Un</th>
                            <th>Amount</th>
                            <th>Total price</th>
                            <th><?= Yii::t('app', 'Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in items" is="order_items" :key="item.id" :index="index" :name="item.name" :amount="item.amount" :unit_price="item.unit_price" :total="item.total"></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <a class="small-box bg-info" href=<?= Url::to(['checkout', 'code' => $code])?>>
            <div class="inner text-center">
                <h3><?= Yii::t('app', 'Checkout') ?></h3>
                <p>Total: {{ total }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </a>
    </div>
</div>