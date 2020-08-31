<?php

namespace app\models;

use app\components\traits\FilterTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "variation_attribute".
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string|null $updated_at
 * @property int $variation_set_id
 *
 * @property ProductVariationAttribute[] $productVariationAttributes
 * @property Product[] $products
 * @property VariationSet $variationSet
 */
class VariationAttribute extends ActiveRecord
{
    use FilterTrait;

    const JOINS = [
        [
            'table' => 'variation_set',
            'on' => 'variation_attribute.variation_set_id = variation_set.id'
        ],
        [
            'table' => 'category',
            'on' => 'variation_set.category_id = category.id'
        ],
        [
            'table' => 'company',
            'on' => 'category.company_id = company.id'
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'variation_attribute';
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
            [['name', 'variation_set_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['variation_set_id'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['variation_set_id'], 'exist', 'skipOnError' => true, 'targetClass' => VariationSet::class, 'targetAttribute' => ['variation_set_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'variation_set_id' => Yii::t('app', 'Variation Set ID'),
        ];
    }

    /**
     * Gets query for [[ProductVariationAttributes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductVariationAttributes()
    {
        return $this->hasMany(ProductVariationAttribute::class, ['variation_attribute_id' => 'id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])->viaTable('product_variation_attribute', ['variation_attribute_id' => 'id']);
    }

    /**
     * Gets query for [[VariationSet]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVariationSet()
    {
        return $this->hasOne(VariationSet::class, ['id' => 'variation_set_id']);
    }
}
