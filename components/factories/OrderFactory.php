<?php

namespace app\components\factories;

use app\models\Order;
use Yii;

class OrderFactory
{
    public static function create()
    {
        $order = new Order();
        $order->company_id = Yii::$app->user->identity->company_id;
        $order->save();

        return $order;
    }
}