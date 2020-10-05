<?php

namespace app\modules\api\controllers;

use app\models\OrderItem;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class OrderItemController extends Controller
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
                    'create' => ['POST'],
                    'validation' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new OrderItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return [
                'orderItem' => $model, 
                'totalOrder' => $model->order->total_value
            ];
        }

        foreach($model->firstErrors as $erro) break;
        throw new BadRequestHttpException($erro);
    }

    public function actionValidation()
    {
        $model = new OrderItem();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }
}
