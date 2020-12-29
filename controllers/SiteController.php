<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\Sale;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => Yii::$app->user->isGuest ? 'center' : 'main',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $info = $this->getInfoDashBoard();

        return $this->render('index', [
            'datas' => $info
        ]);
    }

    private function getInfoDashBoard()
    {
        $date = date('Y-m-d', strtotime("today"));
        $start = $date.' 00:00:00';
        $end = $date.' 23:59:59';

        $total_price = Sale::find()
            ->andWhere(['between', 'sale_at', $start, $end])
            ->andWhere(['is_canceled' => 0])->sum('amount_paid');

        $total_sale = Sale::find()
            ->andWhere(['between', 'sale_at', $start, $end])
            ->andWhere(['is_canceled' => 0])->count();

        return [
            'sales' => $total_sale,
            'total_sales_price' => Yii::$app->formatter->asCurrency((float) $total_price),
        ];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = "login";
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        if (Yii::$app->user->isGuest) 
            $this->redirect('/signup/index');
        
        return $this->goHome();
    }
}
