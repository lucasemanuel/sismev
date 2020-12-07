<?php

namespace app\models;

use app\components\traits\FilterTrait;
use app\components\traits\UpdateCountersTrait;
use app\components\validators\DecimalValidator;
use app\components\validators\ProductExists;
use Yii;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
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
 * @property ProductVariation[] $productVariations
 * @property Variation[] $variations
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

    public $variations_form;

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
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => ['updated_at'],
                    SoftDeleteBehavior::EVENT_BEFORE_SOFT_DELETE => ['deleted_at']
                ]
            ],
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::class,
                'softDeleteAttributeValues' => [
                    'is_deleted' => true
                ],
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
            [['name'], ProductExists::class],
            [['unit_price', 'max_amount', 'min_amount', 'amount'], DecimalValidator::class, 'min' => 0],
            [['is_deleted', 'category_id'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at', 'variations_form'], 'safe'],
            [['code'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 64],
            [['name'], 'trim'],
            [['code'], 'trim'],
            [['code'], 'unique'],
            [['min_amount'], 'compare', 'compareAttribute' => 'max_amount', 'operator' => '<='],
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
            'is_deleted' => Yii::t('app', 'Active'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'category_id' => Yii::t('app', 'Category'),
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
     * Gets query for [[ProductVariations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductVariations()
    {
        return $this->hasMany(ProductVariation::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Variations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVariations()
    {
        return $this->hasMany(Variation::class, ['id' => 'variation_id'])->viaTable('product_variation', ['product_id' => 'id']);
    }

    public function __toString()
    {
        $variations = [];
        foreach($this->productVariations as $variation)
            array_push($variations, $variation->name);

        if (empty($variations))
            return $this->name;

        return $this->name." (".implode(", ", $variations).")";
    }

    public function loadVariationsForm()
    {
        foreach ($this->productVariations as $variation)
            $this->variations_form[$variation->variation_id] = $variation->name;
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
