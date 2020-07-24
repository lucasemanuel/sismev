<?php

namespace app\controllers;

use app\components\factories\AccountFactory;
use app\models\SignupForm;
use Yii;
use yii\db\Exception;

class SignupController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->actionOne();
    }

    public function actionOne()
    {
        Yii::$app->session->destroy();

        $model = new SignupForm(['scenario' => SignupForm::SCENARIO_COMPANY]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->session['signup_form'] = $model->attributes;

            return $this->redirect('two');
        }

        return $this->render('signup_company', [
            'model' => $model,
        ]);
    }

    public function actionTwo()
    {
        $this->validateStepOne();
        $model = new SignupForm(['scenario' => SignupForm::SCENARIO_EMPLOYEE]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                AccountFactory::create(Yii::$app->session['signup_form'], $model->attributes);
                return $this->redirect('/site/login');
            } catch (Exception $e) {
                // Show falied to web user
                return $this->redirect('one');
            }
        }

        return $this->render('signup_employee', [
            'model' => $model,
        ]);
    }


    private function validateStepOne()
    {
        if (Yii::$app->session['signup_form'] === null) {
            return $this->render('signup_company', [
                'model' => new SignupForm(),
            ]);
        }
    }
}
