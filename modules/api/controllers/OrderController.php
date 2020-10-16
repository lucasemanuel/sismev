<?php

namespace app\modules\api\controllers;

use app\models\Order;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class OrderController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['GET'],
                ],
            ],
        ];
    }

    public function actionIndex($id)
    {
        $order = $this->findModel($id);
        return $order;
    }

    protected function findModel($id)
    {
        $model = Order::find()
            ->andWhere(['order.id' => $id])
            ->one();

        if ($model !== null)
            return $model;

        throw new NotFoundHttpException(Yii::t('app', 'Order not exist.'));
    }
}
