<?php

namespace app\components\validators;

use app\models\Product;
use Yii;
use yii\validators\Validator;

class ProductOutputValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $amount = Product::findOne($model->product_id)->amount;

        if ($model->$attribute > $amount) {
            $this->addError($model, $attribute, Yii::t('app', 'The quantity cannot be greater than the total quantity of the product in stock.', [
                'attribute' => $attribute
            ]));
        }
    }
}
