<?php

namespace app\controllers;

use Yii;
use app\models\Expense;
use app\models\ExpenseSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ExpenseController implements the CRUD actions for Expense model.
 */
class ExpenseController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'pay'],
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Expense models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExpenseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Expense model.
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
     * Creates a new Expense model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Expense();
        $model->company_id = Yii::$app->user->identity->company_id;

        if ($model->load(Yii::$app->request->post())) {
            $model->payday = Yii::$app->formatter->asDateDefault($model->payday);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Expense model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->payday = Yii::$app->formatter->asDateDefault($model->payday);
            if ($model->paid_at)
                $model->paid_at = Yii::$app->formatter->asDateDefault($model->payday);

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->payday = Yii::$app->formatter->asDate($model->payday);
        if ($model->paid_at)
            $model->paid_at = Yii::$app->formatter->asDate($model->payday);
            
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Expense model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionPay($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Expense::SCENARIO_PAID;
        $model->is_paid = 1;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->paid_at)
                $model->paid_at = Yii::$app->formatter->asDateDefault($model->paid_at);
            if ($model->save())
                return $this->redirect(['view', 'id' => $id]);
        } else if (!Yii::$app->request->isAjax)
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));

        return $this->renderAjax('pay', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Expense model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Expense the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Expense::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
