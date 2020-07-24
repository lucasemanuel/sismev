<?php

namespace app\controllers;

use Yii;
use app\models\CompanyPhone;
use app\models\CompanyPhoneSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanyPhoneController implements the CRUD actions for CompanyPhone model.
 */
class CompanyPhoneController extends Controller
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
     * Lists all CompanyPhone models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompanyPhoneSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CompanyPhone model.
     * @param integer $company_id
     * @param integer $phone_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($company_id, $phone_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($company_id, $phone_id),
        ]);
    }

    /**
     * Creates a new CompanyPhone model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CompanyPhone();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'company_id' => $model->company_id, 'phone_id' => $model->phone_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CompanyPhone model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $company_id
     * @param integer $phone_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($company_id, $phone_id)
    {
        $model = $this->findModel($company_id, $phone_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'company_id' => $model->company_id, 'phone_id' => $model->phone_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CompanyPhone model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $company_id
     * @param integer $phone_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($company_id, $phone_id)
    {
        $this->findModel($company_id, $phone_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CompanyPhone model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $company_id
     * @param integer $phone_id
     * @return CompanyPhone the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($company_id, $phone_id)
    {
        if (($model = CompanyPhone::findOne(['company_id' => $company_id, 'phone_id' => $phone_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
