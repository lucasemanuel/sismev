<?php

namespace app\controllers;

use Yii;
use app\models\EmployeePhone;
use app\models\EmployeePhoneSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmployeePhoneController implements the CRUD actions for EmployeePhone model.
 */
class EmployeePhoneController extends Controller
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
     * Lists all EmployeePhone models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeePhoneSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmployeePhone model.
     * @param integer $employee_id
     * @param integer $phone_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($employee_id, $phone_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($employee_id, $phone_id),
        ]);
    }

    /**
     * Creates a new EmployeePhone model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmployeePhone();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'employee_id' => $model->employee_id, 'phone_id' => $model->phone_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EmployeePhone model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $employee_id
     * @param integer $phone_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($employee_id, $phone_id)
    {
        $model = $this->findModel($employee_id, $phone_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'employee_id' => $model->employee_id, 'phone_id' => $model->phone_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EmployeePhone model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $employee_id
     * @param integer $phone_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($employee_id, $phone_id)
    {
        $this->findModel($employee_id, $phone_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EmployeePhone model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $employee_id
     * @param integer $phone_id
     * @return EmployeePhone the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($employee_id, $phone_id)
    {
        if (($model = EmployeePhone::findOne(['employee_id' => $employee_id, 'phone_id' => $phone_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
