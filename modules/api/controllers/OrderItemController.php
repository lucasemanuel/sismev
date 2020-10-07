<?php

namespace app\modules\api\controllers;

use app\models\OrderItem;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
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
                    'delete' => ['DELETE'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (in_array($action->id, ['delete'])) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
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

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $model->delete($id);
    }

    public function actionValidation()
    {
        $model = new OrderItem();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    protected function findModel($id)
    {
        $model = OrderItem::find()
            ->andWhere(['id' => $id])
            ->one();

        if ($model !== null)
            return $model;

        throw new NotFoundHttpException(Yii::t('app', 'Order not exist.'));
    }
}
