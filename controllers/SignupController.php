<?php

namespace app\controllers;

use app\components\factories\AccountFactory;
use app\models\Company;
use app\models\Employee;
use Yii;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
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
                    'validate-employee' => ['post'],
                    'validate-company' => ['post']
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

        return $this->render('form', [
            'company' => $company,
            'employee' => $employee,
        ]);
    }

    public function actionCompany()
    {
        $company = new Company(['scenario' => Company::SCENARIO_SIGNUP]);

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $company->load(Yii::$app->request->post());

            if ($company->validate())
                return true;
        
            foreach($company->firstErrors as $erro) break;
            throw new BadRequestHttpException($erro);
       }
    }

    public function actionEmployee()
    {
        $employee = new Employee(['scenario' => Employee::SCENARIO_SIGNUP]);
        $company = new Company(['scenario' => Company::SCENARIO_SIGNUP]);

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $employee->load(Yii::$app->request->post());
            $company->load(Yii::$app->request->post());

            if ($employee->validate())
                return $this->register($company->attributes, $employee->attributes);

            foreach($employee->firstErrors as $erro) break;
            throw new BadRequestHttpException($erro);
        }
    }

    public function actionValidateCompany()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $company = new Company(['scenario' => Company::SCENARIO_SIGNUP]);

        if (Yii::$app->request->isAjax && $company->load(Yii::$app->request->post())) {
            return ActiveForm::validate($company);
        }
    }

    public function actionValidateEmployee()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $employee = new Employee(['scenario' => Employee::SCENARIO_SIGNUP]);

        if (Yii::$app->request->isAjax && $employee->load(Yii::$app->request->post())) {
            return ActiveForm::validate($employee);
        }
    }

    private function register($company, $employee)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        
        $employee['birthday'] = Yii::$app->formatter->asDateDefault($employee['birthday']);

        try {
            $employee['is_manager'] = 1;
            AccountFactory::create($company, $employee);

            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
