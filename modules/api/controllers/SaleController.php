<?php

namespace app\modules\api\controllers;

use app\models\Sale;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SaleController extends Controller
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
        $sale = $this->findModel($id);
        return $sale;
    }

    protected function findModel($id)
    {
        $model = Sale::find()
            ->andWhere(['sale.id' => $id])
            ->one();

        if ($model !== null)
            return $model;

        throw new NotFoundHttpException(Yii::t('app', 'Sale not exist.'));
    }
}
