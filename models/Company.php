<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $name
 * @property string|null $trade_name
 * @property string $ein
 * @property string $email
 * @property string $created_at
 * @property string|null $updated_at
 * @property int $address_id
 *
 * @property Category[] $categories
 * @property Address $address
 * @property CompanyPhone[] $companyPhones
 * @property Phone[] $phones
 * @property Employee[] $employees
 * @property Expense[] $expenses
 * @property Order[] $orders
 * @property PaymentMethod[] $paymentMethods
 */
class Company extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
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
            [['name', 'ein', 'email'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_at'], 'default', 'value' => null],
            [['address_id'], 'integer'],
            [['name', 'trade_name', 'email'], 'string', 'max' => 64],
            [['ein'], 'string', 'max' => 18],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::class, 'targetAttribute' => ['address_id' => 'id']],
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
            'trade_name' => Yii::t('app', 'Trade Name'),
            'ein' => Yii::t('app', 'Ein'),
            'email' => Yii::t('app', 'Email'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'address_id' => Yii::t('app', 'Address ID'),
        ];
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['company_id' => 'id']);
    }

    /**
     * Gets query for [[Address]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::class, ['id' => 'address_id']);
    }

    /**
     * Gets query for [[CompanyPhones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyPhones()
    {
        return $this->hasMany(CompanyPhone::class, ['company_id' => 'id']);
    }

    /**
     * Gets query for [[Phones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhones()
    {
        return $this->hasMany(Phone::class, ['id' => 'phone_id'])->viaTable('company_phone', ['company_id' => 'id']);
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employee::class, ['company_id' => 'id']);
    }

    /**
     * Gets query for [[Expenses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExpenses()
    {
        return $this->hasMany(Expense::class, ['company_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['company_id' => 'id']);
    }

    /**
     * Gets query for [[PaymentMethods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentMethods()
    {
        return $this->hasMany(PaymentMethod::class, ['company_id' => 'id']);
    }
}
