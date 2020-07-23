<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_variation_attribute".
 *
 * @property int $product_id
 * @property int $variation_attribute_id
 *
 * @property Product $product
 * @property VariationAttribute $variationAttribute
 */
class ProductVariationAttribute extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_variation_attribute';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'variation_attribute_id'], 'required'],
            [['product_id', 'variation_attribute_id'], 'integer'],
            [['product_id', 'variation_attribute_id'], 'unique', 'targetAttribute' => ['product_id', 'variation_attribute_id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['variation_attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => VariationAttribute::class, 'targetAttribute' => ['variation_attribute_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('app', 'Product ID'),
            'variation_attribute_id' => Yii::t('app', 'Variation Attribute ID'),
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
     * Gets query for [[VariationAttribute]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVariationAttribute()
    {
        return $this->hasOne(VariationAttribute::class, ['id' => 'variation_attribute_id']);
    }
}
