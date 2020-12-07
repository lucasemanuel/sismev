<?php

namespace app\components\validators;

use app\models\Product;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\validators\Validator;

class ProductExists extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $variations = array_filter($model->variations_form);

        if ($model->$attribute && $this->modelExists($model, $variations)) {
            $this->addError($model, $attribute, Yii::t('app', 'Could not save because the product already exists.'));
        }
    }

    protected function modelExists($model, $variations)
    {
        if (!$variations) {
            $product = Product::find()
                ->leftJoin('product_variation', 'product_variation.product_id = product.id')
                ->andWhere(['product.name' => $model->name])
                ->andWhere(['is', 'product_variation.product_id', new Expression('NULL')])
                ->exists();

            return $product;
        }

        $query = Product::find()
            ->andWhere(['product.name' => $model->name])
            ->andWhere(['product.category_id' => $model->category_id])
            ->andWhere(['in', 'product_variation.name', array_values($variations)])
            ->andWhere(['in', 'product_variation.variation_id', array_keys($variations)])
            ->innerJoinWith('productVariations');

        if (!$model->isNewRecord)
            $query->andWhere(['not', ['product.id' => $model->id]]);

        $query = $query->asArray()->all();

        $product_variations = array_map(function ($product) {
            $array = ArrayHelper::map($product['productVariations'], 'variation_id', 'name');
            ksort($array);
            return $array;
        }, $query);

        ksort($variations);
        foreach ($product_variations as $vars) {
            $array = array_merge(array_diff_assoc($variations, $vars), array_diff_assoc($vars, $variations));
            if (!$array) return true;
        }

        return false;
    }
}
