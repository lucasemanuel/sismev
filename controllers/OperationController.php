<?php

namespace app\controllers;

use app\models\Operation;
use app\models\OperationSearch;
use app\models\Product;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * OperationController implements the CRUD actions for Operation model.
 */
class OperationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Operation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OperationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Operation model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Operation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($product_id = null)
    {
        $model = new Operation();
        $model->attributes = [
            'employee_id' => Yii::$app->user->id,
            'product_id' => $product_id
        ];

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $amount = $model->in_out == 0 ? $model->amount * -1 : $model->amount;

            if ($model->save())
                $model->product->updateCounters(['amount' => $amount]);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'products' => ArrayHelper::map(Product::find()->all(), 'id', function ($product) {
                return $product->__toString();
            })
        ]);
    }

    /**
     * Deletes an existing Operation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        if (!$model->is_deleted) {
            $product = $model->product;
            $amount = $model->in_out == 1 ? $model->amount * -1 : $model->amount;
            $product->amount += $amount;

            if ($product->update())
                $model->softDelete();
            else
                Yii::$app->session->setFlash('warning', $product . ": " . $product->errors['amount'][0]);

        } else {
            Yii::$app->session->setFlash('info', Yii::t('app', 'The operation was undone earlier.'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Operation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Operation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Operation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
