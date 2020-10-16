<?php

namespace app\models;

use app\components\traits\FilterTrait;
use app\components\validators\DecimalValidator;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order_item".
 *
 * @property int $id
 * @property float $amount
 * @property float $unit_price
 * @property int $order_id
 * @property int $product_id
 *
 * @property Order $order
 * @property Product $product
 */
class OrderItem extends ActiveRecord
{
    use FilterTrait;

    const JOINS = [
        [
            'table' => 'order',
            'on' => 'order_item.order_id = order.id'
        ],
        [
            'table' => 'company',
            'on' => 'order.company_id = company.id'
        ],
    ];

    private $_total;
    private $_default_price;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['product_id'],
                'unique',
                'targetAttribute' => [
                    'order_id', 'product_id'
                ],
                'message' => Yii::t('app', 'This product has already been placed in the order')
            ],
            [['amount', 'unit_price', 'order_id', 'product_id'], 'required'],
            [['amount', 'unit_price', 'total'], DecimalValidator::class],
            [['order_id', 'product_id'], 'integer'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'amount' => Yii::t('app', 'Amount'),
            'unit_price' => Yii::t('app', 'Unit Price'),
            'default_price' => Yii::t('app', 'Default Price'),
            'order_id' => Yii::t('app', 'Order ID'),
            'product_id' => Yii::t('app', 'Product'),
        ];
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

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $order = $this->order;
        $order->updateCounters(['total_value' => $this->total]);
    }

    public function afterDelete()
    {
        parent::afterDelete();

        $order = $this->order;
        $order->updateCounters(['total_value' => $this->total * (-1)]);
    }

    public function getTotal()
    {
        if ($this->amount && $this->unit_price)
            return $this->amount * $this->unit_price;
        
        return 0;
    }

    public function getDefault_price()
    {
        return;
    }

    public function fields()
    {
        return [
            'id',
            'name' => function () {
                return $this->product->__toString();
            },
            'unit_price' => function () {
                return Yii::$app->formatter->asCurrency($this->unit_price);
            },
            'amount' => function () {
                return Yii::$app->formatter->asAmount($this->amount);
            },
            'total' => function () {
                return Yii::$app->formatter->asCurrency($this->total);
            },
        ];
    }
}
