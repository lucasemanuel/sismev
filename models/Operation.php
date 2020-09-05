<?php

namespace app\models;

use Yii;
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
 * @property int $product_id
 * @property int $employee_id
 *
 * @property Employee $employee
 * @property Product $product
 */
class Operation extends \yii\db\ActiveRecord
{
    const MAX_AMOUNT = 99999999.99;

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
            [['in_out', 'product_id', 'employee_id'], 'integer'],
            [['in_out'], 'default', 'value' => 1],
            [['amount'], 'number', 'min' => '00.01', 'max' => self::MAX_AMOUNT],
            [['amount'], 'validateAmount'],
            [['created_at'], 'safe'],
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
            if (($this->$attribute + $amount) > self::MAX_AMOUNT) {
                $this->addError($attribute, Yii::t('app', 'The total quantity of the product may not exceed {max_amount}.', [
                    'max_amount' => self::MAX_AMOUNT
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
            'product_id' => Yii::t('app', 'Product ID'),
            'employee_id' => Yii::t('app', 'Employee ID'),
        ];
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
