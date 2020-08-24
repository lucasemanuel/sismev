<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;

$this->registerCss(
    <<< CSS
    .error-page > .error-content {
        margin: 0;
    }

    .error-messages {
        margin-left: 20px;
    }

    .headline {
        font-size: 100px;
        float: left;
    }    
    CSS
);
?>
<div class="site-error">
    <section class="content">
        <div class="error-page">
            <h4 class="font-weight-light text-center">
                <i class="fas fa-exclamation-triangle text-warning"></i> <?= nl2br(Html::encode($message)) ?>
            </h4>
            <div class="error-content d-flex align-items-center">
                <h2 class="headline text-warning">#<?= nl2br(Html::encode($exception->statusCode)) ?></h2>
                <span class="error-messages">
                    <?= Yii::t('app', 'The above error occurred while the web server was processing your request.') ?>
                    <p>
                        <?= Yii::t('app', 'Return to the <a href="{url}">main page here</a>.', [
                            'url' => Url::to(['index'])
                        ]); ?>
                    </p>
                </span>
            </div>
        </div>
    </section>
</div>