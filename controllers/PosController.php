<?php

namespace app\controllers;

use app\components\factories\OrderFactory;
use app\models\Order;
use app\models\OrderProduct;
use yii\web\Controller;

class PosController extends Controller
{
    public $layout = 'main_alt';

    public function actionIndex($code = null)
    {
        if (is_null($code)) {
            return $this->redirect([
                'index',
                'code' => OrderFactory::create()->code
            ]);
        }

        $order = Order::findByCode($code);

        $item = new OrderProduct();
        $item->order_id = Order::findByCode($code)->id;

        return $this->render('index', [
            'item' => $item,
        ]);    
    }

    public function actionCheckout()
    {
        return $this->render('checkout');
    }
}
