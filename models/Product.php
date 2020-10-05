<?php

namespace app\models;

use app\components\traits\FilterTrait;
use app\components\traits\UpdateCountersTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property float $unit_price
 * @property float $amount
 * @property float|null $max_amount
 * @property float|null $min_amount
 * @property int|null $is_deleted
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int $category_id
 *
 * @property Operation[] $operations
 * @property OrderItem[] $orderItems
 * @property Category $category
 * @property ProductVariationAttribute[] $productVariationAttributes
 * @property VariationAttribute[] $variationAttributes
 */
class Product extends ActiveRecord
{
    use FilterTrait;
    use UpdateCountersTrait;

    const JOINS = [
        [
            'table' => 'category',
            'on' => 'product.category_id = category.id'
        ],
        [
            'table' => 'company',
            'on' => 'category.company_id = company.id'
        ]
    ];

    public $variations;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'unit_price', 'category_id'], 'required'],
            [['unit_price', 'max_amount', 'min_amount', 'amount'], 'double', 'max' => '99999999.99'],
            [['unit_price', 'amount'], 'double', 'min' => '00.00'],
            [['is_deleted', 'category_id'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at', 'variations'], 'safe'],
            [['code'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 64],
            [['code'], 'trim'],
            [['code'], 'unique'],
            [['min_amount'], 'compare', 'compareAttribute' => 'max_amount', 'operator' => '<'],
            [['amount'], 'default', 'value' => 0],
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
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['product_id' => 'id']);
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

    public function __toString()
    {
        $variations = [];
        foreach($this->variationAttributes as $variation)
            array_push($variations, $variation->name);

        if (empty($variations))
            return $this->name;

        return $this->name." (".implode(", ", $variations).")";
    }

    public function loadVariations()
    {
        $variation_sets = VariationSet::findByCategory($this->category);
        
        foreach ($variation_sets as $variation_set) {
            $variation = $this->getVariationAttributes()
                ->andWhere(['variation_set_id' => $variation_set->id])
                ->one(); 
            
            $this->variations[$variation_set->id] = is_null($variation) ? null : $variation->id;
        }
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['name'] = function() {
            return $this->__toString();
        };

        return $fields;
    }
}
