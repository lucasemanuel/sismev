<?php

namespace app\modules\api\controllers;

use app\models\Sale;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

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
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['week'],
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                    [
                        'actions' => ['index', 'update', 'validation'],
                        'allow' => true,
                        'roles' => ['cashier']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['GET'],
                    'update' => ['POST'],
                    'validation' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex($id)
    {
        $sale = $this->findModel($id);
        return $sale;
    }

    public function actionWeek()
    {
        $data = [
            'dates' => [],
            'amount_paid' => [
                'label' => Yii::t('app', 'Sales value'),
                'values' => []
            ],
            'total_sale' => [
                'label' => Yii::t('app', 'Total sales'),
                'values' => []
            ]
        ];

        for ($i = 7; $i > 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i day"));
            $start = $date.' 00:00:00';
            $end = $date.' 23:59:59';
            $amount_paid = Sale::find()
                ->andWhere(['between', 'sale_at', $start, $end])
                ->andWhere(['is_canceled' => 0])->sum('amount_paid');

            $total_sale = Sale::find()
                ->andWhere(['between', 'sale_at', $start, $end])
                ->andWhere(['is_canceled' => 0])->count();

            array_push($data['dates'], Yii::$app->formatter->asDate($date));
            array_push($data['amount_paid']['values'], (float) $amount_paid);
            array_push($data['total_sale']['values'], $total_sale);
        }

        return $data;
    }

    public function actionValidation()
    {
        $model = new Sale();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    public function actionUpdate()
    {
        $data = (Object) Yii::$app->request->post('Sale');
        $model = self::findModel($data->id);

        if ($model->consumer_name === $data->consumer_name && $model->consumer_document === $data->consumer_document) {
            return [
                'title' => Yii::t('app', 'Not Modified'),
                'message' => Yii::t('app', 'There Was No Change In Consumer Information.'),
                'status' => 304
            ];
        }

        $model->updateAttributes($data);

        if ($model->hasErrors())
            return $model->getFirstErrors();

        return [
            'title' => Yii::t('app', 'Success'),
            'message' => Yii::t('app', 'Updated Consumer Information!'),
            'status' => 200
        ];
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
