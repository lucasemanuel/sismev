<?php

namespace app\models;

use app\components\traits\FilterTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "variation_set".
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string|null $updated_at
 * @property int $category_id
 *
 * @property VariationAttribute[] $variationAttributes
 * @property Category $category
 */
class VariationSet extends ActiveRecord
{
    use FilterTrait;

    const JOINS = [
        [
            'table' => 'category',
            'on' => 'variation_set.category_id = category.id'
        ],
        [
            'table' => 'company',
            'on' => 'category.company_id = company.id'
        ],
    ];

    private $fullName;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'variation_set';
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
            'name' => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'category_id' => Yii::t('app', 'Category ID'),
        ];
    }

    /**
     * Gets query for [[VariationAttributes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVariationAttributes()
    {
        return $this->hasMany(VariationAttribute::class, ['variation_set_id' => 'id']);
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
