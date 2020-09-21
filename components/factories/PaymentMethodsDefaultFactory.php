<?php

namespace app\components\factories;

use app\models\PaymentMethod;
use Yii;

class PaymentMethodsDefaultFactory
{
    public static function create($company_id)
    {
        $payments_methods = [
            [
                'name' => Yii::t('app', 'Money'),
                'installment_limit' => '01',
            ],
            [
                'name' => Yii::t('app','Credit Card'),
                'installment_limit' => '12',
            ],
            [
                'name' => Yii::t('app','Debit Card'),
                'installment_limit' => '01',
            ],
        ];

        foreach ($payments_methods as $method) {
            $model = new PaymentMethod();
            $model->setAttributes(array_merge($method, ['company_id' => $company_id]));
            $model->save();
        }
    }
}