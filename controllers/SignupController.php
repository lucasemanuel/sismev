<?php

namespace app\controllers;

use app\components\factories\AccountFactory;
use app\models\SignupForm;
use Yii;
use yii\db\Exception;

class SignupController extends \yii\web\Controller
{
    public $layout = "register";

    public function actionIndex()
    {
        return $this->actionStepOne();
    }

    public function actionStepOne()
    {
        $model = new SignupForm(['scenario' => SignupForm::SCENARIO_COMPANY]);

        if (Yii::$app->session['signup_form'] !== null)
            $model->setAttributes(Yii::$app->session['signup_form']);
            
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->session['signup_form'] = $model->attributes;

            return $this->redirect(['step-two']);
        }

        return $this->render('signup_company', [
            'model' => $model,
        ]);
    }

    public function actionStepTwo()
    {
        if (Yii::$app->session['signup_form'] === null)
            return $this->redirect(['step-one']);

        $model = new SignupForm(['scenario' => SignupForm::SCENARIO_EMPLOYEE]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                AccountFactory::create(Yii::$app->session['signup_form'], $model->attributes);
                Yii::$app->session->destroy();
                return $this->redirect('/site/login');
            } catch (Exception $e) {
                // Show falied to web user
                return $this->redirect(['step-one']);
            }
        }

        return $this->render('signup_employee', [
            'model' => $model,
        ]);
    }
}
