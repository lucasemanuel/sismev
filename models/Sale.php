<?php

namespace app\models;

use app\components\Seller;
use app\components\traits\FilterTrait;
use app\components\validators\DecimalValidator;
use app\components\validators\DocumentValidator;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "sale".
 *
 * @property int $id
 * @property float|null $amount_paid
 * @property float|null $discount
 * @property int|null $is_sold
 * @property int|null $is_canceled
 * @property string|null $consumer_name
 * @property string|null $consumer_document
 * @property string|null $sale_at
 * @property string|null $canceled_at
 * @property string|null $updated_at
 * @property int $employee_id
 * @property int $order_id
 *
 * @property Employee $employee
 * @property Pay[] $pays
 * @property Order $order
 */
class Sale extends ActiveRecord
{
    use FilterTrait;

    const JOINS = [
        [
            'table' => 'order',
            'on' => 'sale.order_id = order.id'
        ],
        [
            'table' => 'company',
            'on' => 'order.company_id = company.id'
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale';
    }

    public function init()
    {
        $this->on(Seller::EVENT_COMPLETE_SALE, [Seller::class, 'complete']);

        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount_paid'], DecimalValidator::class],
            [['discount'], 'number', 'max' => DecimalValidator::MAX],
            [['amount_paid', 'discount', 'is_canceled', 'is_sold'], 'default', 'value' => 0],
            [['is_sold', 'is_canceled', 'order_id', 'employee_id'], 'integer'],
            [['consumer_name'], 'string', 'min' => 2, 'max' => 32],
            ['consumer_document', DocumentValidator::class],
            [['sale_at', 'canceled_at', 'updated_at'], 'safe'],
            [['employee_id', 'order_id'], 'required'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::class, 'targetAttribute' => ['employee_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'amount_paid' => Yii::t('app', 'Amount Paid'),
            'discount' => Yii::t('app', 'Discount'),
            'is_sold' => Yii::t('app', 'Is Sold'),
            'is_canceled' => Yii::t('app', 'Is Canceled'),
            'consumer_name' => Yii::t('app', 'Buyer\'s Name'),
            'consumer_document' => Yii::t('app', 'CNPJ/CPF Consumer'),
            'sale_at' => Yii::t('app', 'Sale At'),
            'canceled_at' => Yii::t('app', 'Canceled At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'employee_id' => Yii::t('app', 'Employee'),
            'order_id' => Yii::t('app', 'Order'),
            'order_total_value' => Yii::t('app', 'Order value'),
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
     * Gets query for [[Pays]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPays()
    {
        return $this->hasMany(Pay::class, ['sale_id' => 'id']);
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    public function fields()
    {
        return [
            'consumer_name',
            'consumer_document',
            'total' => function () {
                $this->amount_paid = isset($this->amount_paid) ? $this->amount_paid : 0;
                return Yii::$app->formatter->asCurrency($this->amount_paid);
            },
            'pays',
            'order'
        ];
    }
}
