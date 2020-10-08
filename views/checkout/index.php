<?php
/* @var $this yii\web\View */

use app\assets\AppAsset;
use app\assets\AxiosAsset;
use app\assets\VueAsset;

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
    CSS
)

?>
<div class="checkout-index row">
    <div class="col">
        <?= $this->render('_form', [
            'model' => $pay
        ]); ?>
        <div class="card card-items">
            <div class="card-header border-0">
                <h3 class="card-title"><?= Yii::t('app', 'Payments') ?></h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
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
                    </tbody>
                </table>
            </div>
        </div>
        <a class="small-box bg-info" href="#">
            <div class="inner text-center">
                <h3><?= Yii::t('app', 'Complete Sale') ?></h3>
                <p>Total: {{ total }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </a>
    </div>
</div>