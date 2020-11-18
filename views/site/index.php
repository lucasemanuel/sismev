<?php

/* @var $this yii\web\View */

use app\assets\AxiosAsset;
use app\assets\ChartAsset;

$this->title = 'Dashboard';

AxiosAsset::register($this);
ChartAsset::register($this);

$this->registerJs(
    <<<JS
    axios.get('/api/sale/week').then(({ data }) => {
        const { amount_paid, dates, total_sale } = data;
        var ctx = document.getElementById('salesChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    lineTension: 0.2,
                    label: amount_paid['label'],
                    borderColor: '#28a745',
                    data: amount_paid['values'],
                },
                {
                    lineTension: 0.2,
                    label: total_sale['label'],
                    borderColor: '#dc3545',
                    data: total_sale['values'],
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                        }
                    }]
                }
            }
        });
    })

JS,
    $this::POS_END
);

?>
<div class="site-index">
    <div class="row">
        <div class="col-12 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><?= Yii::t('app', 'Total sales') ?></span>
                    <span class="info-box-number">
                        <?= $datas['sales'] ?>
                        <small>(<?= Yii::t('app', 'Today')?>)</small>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-hand-holding-usd"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><?= Yii::t('app', 'Sales value') ?></span>
                    <span class="info-box-number">
                        <?= $datas['total_sales_price'] ?>
                        <small>(<?= Yii::t('app', 'Today')?>)</small>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="d-none d-sm-block col">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <?= Yii::t('app', 'Last week') ?>
                        (<span class="font-weight-bold"><?= Yii::t('app', 'Sales') ?></span>)
                    </h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <p class="text-center">
                                <strong>
                                    <?= Yii::$app->formatter->asDate(strtotime("-1 week")) ?>
                                    - <?= Yii::$app->formatter->asDate(strtotime("-1 day")) ?>
                                </strong>
                            </p>
                            <div class="chart">
                                <canvas id="salesChart" height="180" style="height: 180px; display: block; width: 638px;" width="638" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>