<?php

namespace app\models;

use app\components\traits\FilterTrait;
use app\components\validators\DecimalValidator;
use Yii;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii2tech\ar\softdelete\SoftDeleteQueryBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "operation".
 *
 * @property int $id
 * @property int $in_out
 * @property float $amount
 * @property string $reason
 * @property string $created_at
 * @property string|null $deleted_at
 * @property int|null $is_deleted
 * @property int $product_id
 * @property int $employee_id
 *
 * @property Employee $employee
 * @property Product $product
 */
class Operation extends \yii\db\ActiveRecord
{
    use FilterTrait;

    const JOINS = [
        [
            'table' => 'employee',
            'on' => 'operation.employee_id = employee.id'
        ],
        [
            'table' => 'company',
            'on' => 'employee.company_id = company.id'
        ]
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operation';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at'],
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
            [['in_out', 'amount', 'reason', 'product_id', 'employee_id'], 'required'],
            [['in_out', 'product_id', 'employee_id', 'is_deleted'], 'integer'],
            [['in_out'], 'default', 'value' => 1],
            [['amount'], DecimalValidator::class],
            [['amount'], 'validateAmount'],
            [['created_at', 'deleted_at'], 'safe'],
            [['reason'], 'string', 'max' => 64],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::class, 'targetAttribute' => ['employee_id' => 'id']],
        ];
    }

    public function validateAmount($attribute, $params, $validator)
    {
        $amount = Product::findOne($this->product_id)->amount;

        if ($this->in_out == 0) {
            if ($this->$attribute > $amount) {
                $this->addError($attribute, Yii::t('app', '"{attribute}" cannot be greater than the total quantity of the product.', [
                    'attribute' => $attribute
                ]));
            }
        } else {
            if (($this->$attribute + $amount) > DecimalValidator::MAX) {
                $this->addError($attribute, Yii::t('app', 'The total quantity of the product may not exceed {max_amount}.', [
                    'max_amount' => DecimalValidator::MAX
                ]));
            }
        }
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
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'product_id' => Yii::t('app', 'Product ID'),
            'employee_id' => Yii::t('app', 'Employee ID'),
        ];
    }

    public static function find()
    {
        $query = parent::find();
        $query->attachBehavior('softDelete', SoftDeleteQueryBehavior::class);
        return $query;
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
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
