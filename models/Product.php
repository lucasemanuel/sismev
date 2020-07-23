<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property float $unit_price
 * @property float $amount
 * @property float $max_amount
 * @property float $min_amount
 * @property int|null $is_deleted
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int $category_id
 *
 * @property Operation[] $operations
 * @property OrderProduct[] $orderProducts
 * @property Order[] $orders
 * @property Category $category
 * @property ProductVariationAttribute[] $productVariationAttributes
 * @property VariationAttribute[] $variationAttributes
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name', 'unit_price', 'amount', 'max_amount', 'min_amount', 'created_at', 'category_id'], 'required'],
            [['unit_price', 'amount', 'max_amount', 'min_amount'], 'number'],
            [['is_deleted', 'category_id'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['code'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 64],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
            'unit_price' => Yii::t('app', 'Unit Price'),
            'amount' => Yii::t('app', 'Amount'),
            'max_amount' => Yii::t('app', 'Max Amount'),
            'min_amount' => Yii::t('app', 'Min Amount'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'category_id' => Yii::t('app', 'Category ID'),
        ];
    }

    /**
     * Gets query for [[Operations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOperations()
    {
        return $this->hasMany(Operation::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[OrderProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['id' => 'order_id'])->viaTable('order_product', ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[ProductVariationAttributes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductVariationAttributes()
    {
        return $this->hasMany(ProductVariationAttribute::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[VariationAttributes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVariationAttributes()
    {
        return $this->hasMany(VariationAttribute::class, ['id' => 'variation_attribute_id'])->viaTable('product_variation_attribute', ['product_id' => 'id']);
    }
}
