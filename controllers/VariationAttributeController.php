<?php

namespace app\controllers;

use app\models\VariationAttribute;
use app\models\VariationAttributeSearch;
use app\models\VariationSet;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * VariationAttributeController implements the CRUD actions for VariationAttribute model.
 */
class VariationAttributeController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
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
     * Lists all VariationAttribute models.
     * @return mixed
     */
    public function actionIndex($variation_set_id = null)
    {
        $searchModel = new VariationAttributeSearch();
        $searchModel->variation_set_id = $variation_set_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VariationAttribute model.
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
     * Creates a new VariationAttribute model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VariationAttribute();
        $listVariationGroup = ArrayHelper::map(VariationSet::find()->orderBy('name')->all(), 'id', 'fullName');

        if ($model->load(Yii::$app->request->post()) && $model->save())
            return $this->redirect('index');
        else if (!Yii::$app->request->isAjax)
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));

        return $this->renderAjax('create', [
            'model' => $model,
            'list' => $listVariationGroup
        ]);
    }

    /**
     * Updates an existing VariationAttribute model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
            return $this->redirect(['view', 'id' => $model->id]);
        else if (!Yii::$app->request->isAjax)
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing VariationAttribute model.
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

    /**
     * Finds the VariationAttribute model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VariationAttribute the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VariationAttribute::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
