<?php

namespace app\controllers;

use app\models\Address;
use app\models\Employee;
use app\models\EmployeeSearch;
use Yii;
use yii\bootstrap4\ActiveForm;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\Response;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller
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
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Employee model.
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

    public function actionProfile()
    {
        $id = Yii::$app->user->id;
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Employee(['scenario' => Employee::SCENARIO_CREATE]);
        $model->is_manager = 0;
        $model->company_id = Yii::$app->user->identity->company_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdateAddress($id)
    {
        $model = $this->findModel($id);
        $address = new Address();

        if (!is_null($model->address_id))
            $address = Address::findOne($model->address_id);            

        if ($address->load(Yii::$app->request->post()) && $address->save()) {
            $address->link('employee', $model);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('address', [
            'address' => $address,
            'model' => $model
        ]);
    }

    /**
     * Updates an existing Employee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Employee::SCENARIO_UPDATE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->birthday = Yii::$app->formatter->asDate($model->birthday);
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionChangePassword($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Employee::SCENARIO_CHANGE_PASSWORD;
        
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->password = $model->password_new;
                $model->save(false);
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }
        $model->password = '';

        return $this->render('change_password', [
            'model' => $model,
        ]);
    }

    public function actionValidatePassword($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = $this->findModel($id);
        $model->scenario = Employee::SCENARIO_CHANGE_PASSWORD;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            return ActiveForm::validate($model);
        }
    }

    /**
     * Deletes an existing Employee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $transaction = Yii::$app->getDb()->beginTransaction();

        try {
            $address = Address::findOne($model->address_id);
            if ($model->delete() && $address->delete()){
                $transaction->commit();
                return $this->redirect(['index']);
            }
    
            throw new BadRequestHttpException(Yii::t('app', 'Failed to delete collaborator.'));
        } catch (BadRequestHttpException $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
