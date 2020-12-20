<?php

namespace app\models;

use app\components\traits\FilterTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "variation".
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string|null $updated_at
 * @property int $category_id
 *
 * @property ProductVariation[] $productVariations
 * @property Product[] $products
 * @property Category $category
 */
class Variation extends ActiveRecord
{
    use FilterTrait;

    const JOINS = [
        [
            'table' => 'category',
            'on' => 'variation.category_id = category.id'
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
        return 'variation';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()')
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'category_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['category_id'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['name'], 'trim'],
            [['name'], function ($attribute, $params, $validator) { 
                if ($this->category_id && $this->$attribute) {
                    $exists = self::find()
                        ->andWhere([
                            'category_id' => $this->category_id,
                            'variation.name' => $this->$attribute])
                        ->exists();
                    if ($exists) $this->addError($attribute, Yii::t('yii', '{attribute} "{value}" has already been taken.', [
                        'attribute' => $this->getAttributeLabel('name'),
                        'value' => $this->$attribute
                    ]));
                }
            }],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'category_id' => Yii::t('app', 'Category'),
        ];
    }

    /**
     * Gets query for [[ProductVariations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductVariations()
    {
        return $this->hasMany(ProductVariation::class, ['variation_id' => 'id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])->viaTable('product_variation', ['variation_id' => 'id']);
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

    public function getFullName()
    {
        return $this->name." ({$this->category->name})";
    }

    public static function findByCategory($category)
    {
        return self::find()
            ->andWhere(['category_id' => $category])
            ->all();
    }
}
