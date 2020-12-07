<?php

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use app\models\ProductSearch;
use app\models\ProductVariation;
use app\models\VariationAttribute;
use Yii;
use yii\db\Expression;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\ConflictHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UnprocessableEntityHttpException;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
                        'actions' => ['index', 'view', 'category', 'create', 'update', 'delete', 'soft-delete', 'restore'],
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'soft-delete' => ['POST'],
                    'restore' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex($active = null)
    {
        $searchModel = new ProductSearch();
        $searchModel->is_deleted = $active;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
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

    public function actionCategory()
    {
        $model = new Product();
        $list = ArrayHelper::map(Category::find()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()))
            return $this->redirect(['create', 'category' => $model->category_id]);
        else if (!Yii::$app->request->isAjax)
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));

        return $this->renderAjax('category', [
            'model' => $model,
            'list' => $list
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($category)
    {
        if (is_null(Category::findOne($category)))
            throw new NotFoundHttpException(Yii::t('app', 'Seleted category not found.'));

        $model = new Product();
        $model->category_id = $category;

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Product::getDb()->beginTransaction();
            try {
                $variations = array_filter($model->variations_form);

                if (!$model->save() && $errors = $model->errors) {
                    throw new BadRequestHttpException(array_shift($errors)[0]);
                }

                foreach ($variations as $id => $value) {
                    $this->saveProductVariation([
                        'variation_id' => $id,
                        'name' => $value,
                        'product_id' => $model->id,
                    ]);
                }

                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    private function saveProductVariation($attributes)
    {
        $product_variation = new ProductVariation();
        $product_variation->attributes = $attributes;

        if (!$product_variation->save())
            throw new BadRequestHttpException(Yii::t('app', 'Failed to save the product, try again later.'));
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->loadVariations();

        if ($model->load(Yii::$app->request->post())) {
            $model->variations = array_filter($model->variations);

            if ($this->modelExists($model))
                throw new ConflictHttpException(Yii::t('app', 'Could not save because the product already exists.'));

            $model->save();
            $model->unlinkAll('variationAttributes', true);

            foreach ($model->variations as $var_id) (VariationAttribute::findOne($var_id))->link('products', $model);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (!$model->operations && !$model->orderItems) {
            $model->delete();
        } else {
            Yii::$app->session->setFlash('warning', Yii::t('app', 'It is not possible to delete the product permanently, as the product is linked to input/output operations or is present in some order.'));
        }

        return $this->redirect(['index']);
    }

    public function actionSoftDelete($id)
    {
        $this->findModel($id)->softDelete();

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionRestore($id)
    {
        $this->findModel($id)->restore();

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
