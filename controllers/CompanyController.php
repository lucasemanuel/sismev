<?php

namespace app\controllers;

use app\models\Address;
use app\models\Company;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends Controller
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

    public function actionIndex()
    {
        $company_id = Yii::$app->user->identity->company_id;
        $model = $this->findModel($company_id);

        if (!isset($model->address_id))
            Yii::$app->session->setFlash('info', Yii::t('app', "Haven't you registered your business address yet? Register now."));

        return $this->render('index', [
            'model' => $this->findModel($company_id),
        ]);
    }

    public function actionUpdateAddress()
    {
        $company_id = Yii::$app->user->identity->company_id;
        $model = $this->findModel($company_id);

        $address = new Address();

        if (!is_null($model->address_id))
            $address = Address::findOne($model->address_id);            

        if ($address->load(Yii::$app->request->post()) && $address->save()) {
            $address->link('company', $model);
            return $this->redirect(['index']);
        }

        return $this->render('address', [
            'address' => $address,
            'model' => $model
        ]);
    }

    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        $company_id = Yii::$app->user->identity->company_id;
        $model = $this->findModel($company_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Company model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        $company_id = Yii::$app->user->identity->company_id;
        $company = $this->findModel($company_id);

        Yii::$app->user->logout();

        $company->delete();
        return $this->redirect(['/site/index']);
    }

    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
