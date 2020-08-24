<?php

namespace app\controllers;

use app\components\factories\AccountFactory;
use app\models\Company;
use app\models\Employee;
use Yii;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SignupController extends Controller
{
    public $layout = "register";

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get', 'post'],
                    'next' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest)
            return $this->goHome();

        $company = new Company(['scenario' => Company::SCENARIO_SIGNUP]);
        $employee = new Employee(['scenario' => Employee::SCENARIO_SIGNUP]);

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $company->load(Yii::$app->request->post());
            $employee->load(Yii::$app->request->post());

            if ($company->validate() && $employee->validate())
                $this->register($company->attributes, $employee->attributes);
            
            return array_merge(ActiveForm::validate($company),ActiveForm::validate($employee));
        }

        return $this->render('form_signup', [
            'company' => $company,
            'employee' => $employee,
        ]);
    }

    public function actionNext()
    {
        if (!Yii::$app->user->isGuest)
            return $this->goHome();

        $model = new Company(['scenario' => Company::SCENARIO_SIGNUP]);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    private function register($company, $employee)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        
        $employee['birthday'] = implode("-",array_reverse(explode("/",$employee['birthday'])));

        try {
            $employee['is_manager'] = 1;
            AccountFactory::create($company, $employee);

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        $this->redirect(['site/login']);
    }
}
