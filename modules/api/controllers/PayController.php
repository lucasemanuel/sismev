<?php

namespace app\modules\api\controllers;

use app\models\Pay;
use app\models\PaymentMethod;
use app\models\Sale;
use Yii;
use yii\db\conditions\LikeCondition;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class PayController extends Controller
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
                        'actions' => ['create', 'delete', 'validation', 'query'],
                        'allow' => true,
                        'roles' => ['cashier']
                    ],
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
        $model = new Pay();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return [
                'pay' => $model, 
                'total' => $model->sale->toArray()['total']
            ];
        }

        foreach($model->firstErrors as $erro) break;
        throw new BadRequestHttpException($erro);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $saleId = $model->sale_id;

        $model->delete($id);

        return [ 
            'total' => Sale::findOne($saleId)->amount_paid
        ];
    }

    public function actionValidation()
    {
        $model = new Pay();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    public function actionQuery($q = null, $id = null)
    {
        $out = ['results' => ['id' => '', 'name' => '', 'max_installments' => '']];

        if (!is_null($q)) {
            $data = PaymentMethod::find()
                ->andWhere(new LikeCondition('payment_method.name', 'LIKE', $q))
                ->andWhere(['is_deleted' => 0])
                ->asArray()
                ->all();
            
            $out['results'] = $data;
        }
        return $out;
    }

    protected function findModel($id)
    {
        $model = Pay::find()
            ->andWhere(['id' => $id])
            ->one();

        if ($model !== null)
            return $model;

        throw new NotFoundHttpException(Yii::t('app', 'Payment not exist.'));
    }
}
