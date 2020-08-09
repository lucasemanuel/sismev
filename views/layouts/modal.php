<?php

use yii\bootstrap4\Modal;

Modal::begin(array_merge(['id' => 'modal'], $options));

echo '<div id="content-modal"></div>';

Modal::end();
