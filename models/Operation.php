<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "operation".
 *
 * @property int $id
 * @property int $in_out
 * @property float $amount
 * @property string $reason
 * @property string $created_at
 * @property string|null $updated_at
 * @property int $product_id
 *
 * @property Product $product
 */
class Operation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['in_out', 'amount', 'reason', 'created_at', 'product_id'], 'required'],
            [['in_out', 'product_id'], 'integer'],
            [['amount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['reason'], 'string', 'max' => 64],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'in_out' => Yii::t('app', 'In Out'),
            'amount' => Yii::t('app', 'Amount'),
            'reason' => Yii::t('app', 'Reason'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'product_id' => Yii::t('app', 'Product ID'),
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
