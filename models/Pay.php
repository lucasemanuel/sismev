<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pay".
 *
 * @property int $id
 * @property float $value
 * @property int|null $installments
 * @property int $payment_method_id
 * @property int $sale_id
 *
 * @property PaymentMethod $paymentMethod
 * @property Sale $sale
 */
class Pay extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pay';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'payment_method_id', 'sale_id'], 'required'],
            [['value'], 'number'],
            [['installments', 'payment_method_id', 'sale_id'], 'integer'],
            [['installments'], 'default', 'value' => 1],
            [['installments'], function ($attribute, $params, $validator) {
                if ($this->paymentMethod !== null && $this->$attribute > $this->paymentMethod->installment_limit) {
                    $this->addError($attribute, Yii::t('app', 'Installment above the limit defined in payment method.'));
                }
            }],
            [['payment_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentMethod::class, 'targetAttribute' => ['payment_method_id' => 'id']],
            [['sale_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sale::class, 'targetAttribute' => ['sale_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'value' => Yii::t('app', 'Value'),
            'installments' => Yii::t('app', 'Installments'),
            'payment_method_id' => Yii::t('app', 'Payment Method ID'),
            'sale_id' => Yii::t('app', 'Sale ID'),
        ];
    }

    /**
     * Gets query for [[PaymentMethod]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentMethod()
    {
        return $this->hasOne(PaymentMethod::class, ['id' => 'payment_method_id']);
    }

    /**
     * Gets query for [[Sale]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasOne(Sale::class, ['id' => 'sale_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $sale = $this->sale;
        $sale->updateCounters(['amount_paid' => $this->value]);
    }
}
