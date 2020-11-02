<?php

namespace app\controllers;

use app\models\Operation;
use Yii;
use app\models\Sale;
use app\models\SaleSearch;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;

/**
 * SaleController implements the CRUD actions for Sale model.
 */
class SaleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'invoice', 'canceled'],
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'canceled' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Sale models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SaleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInvoice($id)
    {
        return $this->render('invoice', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCanceled($id)
    {
        $model = $this->findModel($id);

        if (!$model->is_canceled) {
            try {
                $model->attributes = [
                    'is_canceled' => 1,
                    'canceled_at' => new Expression('NOW()')
                ];
    
                if (!$model->save()) {
                    foreach($model->firstErrors as $erro) break;
                    throw new BadRequestHttpException($erro);
                }

                foreach ($model->order->orderItems as $item) {
                    $operation = new Operation();
                    $operation->attributes = [
                        'in_out' => 1,
                        'amount' => $item->amount,
                        'reason' => Yii::t('app', 'Canceled Sale'),
                        'product_id' => $item->product_id,
                        'employee_id' => Yii::$app->user->id,
                    ];
    
                    if (!$operation->save()) {
                        foreach($operation->firstErrors as $erro) break;
                        throw new BadRequestHttpException($erro);
                    }
                }
            } catch (HttpException $e) {
                Yii::$app->session->setFlash('danger', $e->message);
            }
        } else
            Yii::$app->session->setFlash('warning', Yii::t('app', 'The sale has already been canceled.'));

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sale model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sale the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sale::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested order does not exist.'));
    }
}
