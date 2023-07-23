<?php

use app\assets\SaleAsset;
use kartik\dialog\Dialog;
use yii\helpers\Html;
use yii\helpers\Url;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

/* @var $this yii\web\View */
/* @var $model app\models\Sale */

$this->title = Yii::t('app', 'Order #{code}', ['code' => $model->order->code]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sales'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$company = Yii::$app->user->identity->company;

$this->registerCss(
    <<< CSS
        .invoice-col:nth-child(2) {
            margin-bottom: 1rem;
        }
    CSS
);

$env = (object) $_ENV;

$coupon_print_icon = '<i class="fas fa-print"></i>';
$coupon_print_icon_file = Yii::getAlias('@webroot') . DS . 'images' . DS . ($_ENV['COUPON_PRINT_ICON'] ?? null);
$coupon_print_logo_file = Yii::getAlias('@webroot') . DS . 'images' . DS . ($_ENV['COUPON_LOGO'] ?? null);
$coupon_print_icon_key_exists = isset($_ENV['COUPON_LOGO']) && !empty($_ENV['COUPON_LOGO']);
$coupon_print_image_exists = file_exists($coupon_print_logo_file);
$coupon_print_logo = $coupon_print_icon_key_exists && $coupon_print_image_exists;

SaleAsset::register($this);
Dialog::widget();
?>
<?php if (!$coupon_print_logo): ?>
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?= Yii::t('app', !$coupon_print_icon_key_exists
                          ? 'The {key} Key Does Not Exist In The .env File Or Has No Value.'
                          : 'Image {file} Does Not Exist.', ['file' => $coupon_print_logo_file, 'key' => 'COUPON_LOGO'])
        ?>
    </div>
<?php endif ?>

<?php if (!isset($env->QRCODE_TEXT) || empty($env->QRCODE_TEXT)): ?>
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?= Yii::t('app', 'The {key} Key Does Not Exist In The .env File Or Has No Value.', ['key' => 'QRCODE_TEXT'])
        ?>
    </div>
<?php endif ?>

<div class="coupon d-none">
    <small><?= $company->trade_name ?></small>
    <div class="info">
        <?php if ($company->address) echo "<small>{$company->address}</small>"; ?>
        <small>CNPJ: <?= $company->ein ?></small>
        <small><?= Yii::t('app', 'Attendant') ?>: <?= $model->employee->usual_name ?></small>
    </div>

    <div class="info-order">
        <small><?= $model->sale_at ? Yii::$app->formatter->asDateTime($model->sale_at) : '<i>(sem data)</i>' ?><span>#<?= $model->order->code ?></span></small>
    </div>

    <?php if ($model->consumer_name) : ?>
        <div>
            <?php if ($model->consumer_name && $model->consumer_document) : ?><small><?= Yii::t('app', 'CNPJ/CPF Consumer') ?>: <?= $model->consumer_document ?></small><?php endif ?>
            <?php if ($model->consumer_name) : ?><small><?= Yii::t('app', 'Buyer\'s Name') ?>: <?= $model->consumer_name ?></small><?php endif ?>
        </div>
    <?php endif ?>

    <div class="receipt">
        <h1 class="tax-receipt"><?= Yii::t('app', 'Non-Tax Coupon') ?></h1>
        <small><?= Yii::t('app', 'Item Code Description Qty.un.VL.Unit($)') ?></small>
        <small><?= Yii::t('app', 'Item ($)') ?></small>
    </div>

    <div class="receipt">
        <?php $index = 1; foreach ($model->order->orderItems as $item) : ?>
            <small><?= str_pad($index, 3, "0", STR_PAD_LEFT) ?>&nbsp;&nbsp;<?= $item->product->code ?><span><?= $item->product ?></span></small>
            <small class="tab">
                <?= Yii::$app->formatter->asInteger($item->amount) ?>un x <?= Yii::$app->formatter->asAmount($item->unit_price) ?>
                <span><?= Yii::$app->formatter->asAmount($item->total) ?></span>
            </small>
        <?php $index++; endforeach; ?>

        <small class="bold">
            Total&nbsp;&nbsp;R$
            <span><?= Yii::$app->formatter->asAmount(Yii::$app->formatter->asFloat($model->order->toArray()['total_value'])) ?></span>
        </small>

        <?php foreach ($model->pays as $pay) : ?>
            <?php $pay = $pay->toArray(); ?>
            <small><?= $pay['name'] ?><span><?= Yii::$app->formatter->asAmount(Yii::$app->formatter->asFloat($pay['value'])) ?></span></small>
        <?php endforeach; ?>
    </div>

    <!-- <div>
        <small><?= Yii::t('app', 'Total Tax') ?><span><?= Yii::$app->formatter->asCurrency(Yii::$app->formatter->asFloat($model->order->toArray()['total_value']) * .1) ?> (10%)</span></small>
    </div> -->

    <?php if (isset($env->QRCODE_TEXT)): ?>
        <div class="logo"<?php if (!$coupon_print_logo) echo ' style="justify-content:center"' ?>>
            <?php $writer = new PngWriter();

                // Create QR code
                $qrCode = QrCode::create($env->QRCODE_TEXT)
                    ->setEncoding(new Encoding('UTF-8'))
                    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
                    ->setSize(150)
                    ->setMargin(0)
                    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
                    ->setForegroundColor(new Color(0, 0, 0))
                    ->setBackgroundColor(new Color(255, 255, 255));

                $result = $writer->write($qrCode);
            ?><img src="<?= $result->getDataUri() ?>">
            <?php if ($coupon_print_logo): ?><img src="<?= Url::base() . '/images/' . $env->COUPON_LOGO ?>"><?php endif ?>
        </div>
    <?php endif ?>
</div>

<div class="sale-view row">
    <?php if ($model->is_canceled): ?>
        <div class="col-12">
            <div class="info-box bg-danger">
                <div class="info-box-content">
                    <h2 class="font-weight-bold text-uppercase text-center"><?= Yii::t('app', 'Canceled Sale') ?></h2>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-12">
        <div class="invoice p-3 mb-3">
            <div class="row">
                <div class="col-12">
                    <h4>
                        <i class="fas fa-globe"></i>
                        <?= $company->trade_name ?>
                    </h4>
                </div>
            </div>

            <div class="row invoice-info">
                <div class="col-sm-6 invoice-col">
                    <address>
                        <strong><?= $company->trade_name ?></strong><br>
                        <?php if ($company->address) : ?>
                            <?= $company->address->street . ', ' . $company->address->number . ', ' . $company->address->neighborhood ?><br>
                            <?= $company->address->city . ', ' . $company->address->federated_unit . ' - ' . $company->address->zip_code ?><br>
                        <?php else : ?>
                            <?= Yii::t('app', 'Company address not defined') ?><br>
                        <?php endif; ?>
                        <?= Yii::t('app', 'Phone') . ': ' . $company->phone_number ?><br>
                        <?= Yii::t('app', 'E-mail') . ': ' . $company->email ?><br>
                    </address>
                </div>
                <div class="col-sm-6 invoice-col">
                    <b><?= Yii::t('app', 'Order #{code}', ['code' => $model->order->code]) ?></b><br>
                    <b><?= Yii::t('app', 'Sold in:') ?></b> <?= Yii::$app->formatter->asDateTime($model->sale_at) ?><br>
                    <b><?= Yii::t('app', 'Amount Paid:') ?></b> <?= Yii::$app->formatter->asCurrency($model->amount_paid) ?><br>
                    <b><?= Yii::t('app', 'Cashier') ?>:</b> <?= $model->employee->full_name ?><br>
                    <b><?= Yii::t('app', 'Buyer\'s Name') ?>:</b> <?= Yii::$app->formatter->asNull($model->consumer_name) ?><br>
                    <b><?= Yii::t('app', 'CNPJ/CPF Consumer') ?>:</b> <?= Yii::$app->formatter->asNull($model->consumer_document) ?><br>
                    <?php if ($model->is_canceled) : ?>
                        <b><?= Yii::t('app', 'Canceled Sale') ?></b><br>
                        <b><?= Yii::t('app', 'Canceled At') ?>:</b> <?= Yii::$app->formatter->asDateTime($model->canceled_at) ?><br>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
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
                            <?php foreach ($model->order->orderItems as $item) : ?>
                                <?php $index += 1; ?>
                                <tr>
                                    <td><?= $index ?></td>
                                    <td><?= $item->product ?></td>
                                    <td><?= Yii::$app->formatter->asCurrency($item->unit_price) ?></td>
                                    <td><?= Yii::$app->formatter->asAmount($item->amount) ?></td>
                                    <td><?= Yii::$app->formatter->asCurrency($item->total) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="6" class="font-weight-bold text-center">
                                    <?= Yii::t('app', 'Total') . ': ' . $model->order->toArray()['total_value'] ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <p class="lead"><?= Yii::t('app', 'Payment') . ':' ?></p>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <?php foreach ($model->pays as $pay) : ?>
                                    <?php $pay = $pay->toArray(); ?>
                                    <tr>
                                        <td class="font-weight-bold" style="width: 70%"><?= $pay['name'] ?></td>
                                        <td style="width: 15%"><?= $pay['installments'] ?></td>
                                        <td style="width: 15%"><?= $pay['value'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="6" class="font-weight-bold text-center">
                                        <?= Yii::t('app', 'Total') . ': ' . $model->toArray()['total'] ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6 no-print text-right">
                    <p class="lead"><?= Yii::t('app', 'Actions') . ':' ?></p>
                    <p>
                        <?php if (file_exists($coupon_print_icon_file) && is_file($coupon_print_icon_file)) $coupon_print_icon = @file_get_contents($coupon_print_icon_file); ?>
                        <button onclick="printCoupon()" class="btn btn-success"><?= $coupon_print_icon ?> <?= Yii::t('app', 'Print Coupon') ?></button>
                        <button onclick='print()' class="btn btn-default"><i class="fas fa-print"></i> <?= Yii::t('app', 'Print') ?></button>
                        <?php if (!$model->is_canceled) : ?>
                            <?= Html::a(Yii::t('app', 'Cancel'), ['canceled', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to cancel this sale?') . '<br>' . Yii::t('app', 'All transactions made because of this sale will be reversed.'),
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>