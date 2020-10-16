<?php

use yii\helpers\Html;

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
?>
<div class="sale-view row">
    <div class="col">
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
                        <?php if ($company->address): ?>
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
                    <b><?= Yii::t('app', 'Cashier:') ?></b> <?= $model->employee->full_name ?><br>
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
                                    <?= Yii::t('app', 'Total:') . ' ' . $model->order->toArray()['total_value'] ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <p class="lead"><?= Yii::t('app', 'Payment').':' ?></p>
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
                                        <?= Yii::t('app', 'Total Paid:') . ' ' . $model->toArray()['total'] ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6 no-print text-right">
                    <p class="lead"><?= Yii::t('app', 'Actions').':' ?></p>
                    <p>
                        <button onclick='print()' class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                        <?= Html::a(Yii::t('app', 'Revert'), ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>