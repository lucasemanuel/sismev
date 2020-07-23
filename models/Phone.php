<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "phone".
 *
 * @property int $id
 * @property string $number
 *
 * @property CompanyPhone[] $companyPhones
 * @property Company[] $companies
 * @property EmployeePhone[] $employeePhones
 * @property Employee[] $employees
 */
class Phone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number'], 'required'],
            [['number'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'number' => Yii::t('app', 'Number'),
        ];
    }

    /**
     * Gets query for [[CompanyPhones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyPhones()
    {
        return $this->hasMany(CompanyPhone::class, ['phone_id' => 'id']);
    }

    /**
     * Gets query for [[Companies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::class, ['id' => 'company_id'])->viaTable('company_phone', ['phone_id' => 'id']);
    }

    /**
     * Gets query for [[EmployeePhones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeePhones()
    {
        return $this->hasMany(EmployeePhone::class, ['phone_id' => 'id']);
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employee::class, ['id' => 'employee_id'])->viaTable('employee_phone', ['phone_id' => 'id']);
    }
}
