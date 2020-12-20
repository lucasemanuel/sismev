<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product_variation".
 *
 * @property int $product_id
 * @property string $name
 * @property int $variation_id
 *
 * @property Product $product
 * @property Variation $variation
 */
class ProductVariation extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_variation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'name', 'variation_id'], 'required'],
            [['product_id', 'variation_id'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['product_id', 'variation_id'], 'unique', 'targetAttribute' => ['product_id', 'variation_id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['variation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Variation::class, 'targetAttribute' => ['variation_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
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

    /**
     * Gets query for [[Variation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVariation()
    {
        return $this->hasOne(Variation::class, ['id' => 'variation_id']);
    }
}
