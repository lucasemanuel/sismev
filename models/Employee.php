<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string $full_name
 * @property string $usual_name
 * @property string $ssn
 * @property string $birthday
 * @property string $email
 * @property string $password
 * @property int|null $is_manager
 * @property int|null $is_deleted
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int $address_id
 * @property int $company_id
 *
 * @property Address $address
 * @property Company $company
 * @property EmployeePhone[] $employeePhones
 * @property Phone[] $phones
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'usual_name', 'ssn', 'birthday', 'email', 'password', 'created_at', 'address_id', 'company_id'], 'required'],
            [['birthday', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['is_manager', 'is_deleted', 'address_id', 'company_id'], 'integer'],
            [['full_name'], 'string', 'max' => 128],
            [['usual_name'], 'string', 'max' => 32],
            [['ssn'], 'string', 'max' => 12],
            [['email'], 'string', 'max' => 64],
            [['password'], 'string', 'max' => 255],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::class, 'targetAttribute' => ['address_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'full_name' => Yii::t('app', 'Full Name'),
            'usual_name' => Yii::t('app', 'Usual Name'),
            'ssn' => Yii::t('app', 'Ssn'),
            'birthday' => Yii::t('app', 'Birthday'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'is_manager' => Yii::t('app', 'Is Manager'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'address_id' => Yii::t('app', 'Address ID'),
            'company_id' => Yii::t('app', 'Company ID'),
        ];
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
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    /**
     * Gets query for [[EmployeePhones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeePhones()
    {
        return $this->hasMany(EmployeePhone::class, ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[Phones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhones()
    {
        return $this->hasMany(Phone::class, ['id' => 'phone_id'])->viaTable('employee_phone', ['employee_id' => 'id']);
    }
}
