<?php

namespace app\controllers;

use Yii;
use app\models\ProductVariationAttribute;
use app\models\ProductVariationAttributeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductVariationAttributeController implements the CRUD actions for ProductVariationAttribute model.
 */
class ProductVariationAttributeController extends Controller
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
     * Lists all ProductVariationAttribute models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductVariationAttributeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductVariationAttribute model.
     * @param integer $product_id
     * @param integer $variation_attribute_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($product_id, $variation_attribute_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($product_id, $variation_attribute_id),
        ]);
    }

    /**
     * Creates a new ProductVariationAttribute model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductVariationAttribute();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'product_id' => $model->product_id, 'variation_attribute_id' => $model->variation_attribute_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProductVariationAttribute model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $product_id
     * @param integer $variation_attribute_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($product_id, $variation_attribute_id)
    {
        $model = $this->findModel($product_id, $variation_attribute_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'product_id' => $model->product_id, 'variation_attribute_id' => $model->variation_attribute_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProductVariationAttribute model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $product_id
     * @param integer $variation_attribute_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($product_id, $variation_attribute_id)
    {
        $this->findModel($product_id, $variation_attribute_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductVariationAttribute model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $product_id
     * @param integer $variation_attribute_id
     * @return ProductVariationAttribute the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($product_id, $variation_attribute_id)
    {
        if (($model = ProductVariationAttribute::findOne(['product_id' => $product_id, 'variation_attribute_id' => $variation_attribute_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
