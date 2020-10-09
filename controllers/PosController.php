<?php

namespace app\controllers;

use app\components\factories\OrderFactory;
use app\components\factories\SaleFactory;
use app\models\Order;
use app\models\OrderItem;
use app\models\Pay;
use app\models\Sale;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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

        $item = new OrderItem();
        $item->order_id = Order::findByCode($code)->id;

        return $this->render('index', [
            'item' => $item,
            'code' => $code,
        ]);    
    }

    public function actionCheckout($code)
    {
        $order = $this->findOrder($code);
        
        if (!$order->orderItems) {
            Yii::$app->session->setFlash('info', Yii::t('app', "You cannot go to checkout without at least one item in the order."));
            return $this->redirect(['index', 'code' => $order->code]);
        }

        $sale = $order->sale;
        if ($sale === null) {
            $sale = SaleFactory::create([
                'order_id' => $order->id
            ]);
        }
        
        $payment = new Pay();
        $payment->sale_id = $sale->id;

        return $this->render('/checkout/index', [
            'pay' => $payment,
            'code' => $code
        ]);
    }

    public function actionComplete($code)
    {
        $sale = $this->findOrder($code)->sale;

        $this->trigger(Sale::EVENT_COMPLETE_SALE);
        return;
    }

    protected function findOrder($code)
    {
        if (($model = Order::findByCode($code)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested order does not exist.'));
    }
}
