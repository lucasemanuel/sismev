<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sale".
 *
 * @property int $id
 * @property float|null $amount_paid
 * @property float|null $discount
 * @property string|null $sale_at
 * @property string|null $canceled_at
 * @property string|null $updated_at
 * @property int $order_id
 *
 * @property Pay[] $pays
 * @property Order $order
 */
class Sale extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount_paid', 'discount'], 'number'],
            [['sale_at', 'canceled_at', 'updated_at'], 'safe'],
            [['order_id'], 'required'],
            [['order_id'], 'integer'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'amount_paid' => Yii::t('app', 'Amount Paid'),
            'discount' => Yii::t('app', 'Discount'),
            'sale_at' => Yii::t('app', 'Sale At'),
            'canceled_at' => Yii::t('app', 'Canceled At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'order_id' => Yii::t('app', 'Order ID'),
        ];
    }

    /**
     * Gets query for [[Pays]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPays()
    {
        return $this->hasMany(Pay::class, ['sale_id' => 'id']);
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }
}
