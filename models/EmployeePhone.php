<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_phone".
 *
 * @property int $employee_id
 * @property int $phone_id
 *
 * @property Employee $employee
 * @property Phone $phone
 */
class EmployeePhone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_phone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'phone_id'], 'required'],
            [['employee_id', 'phone_id'], 'integer'],
            [['employee_id', 'phone_id'], 'unique', 'targetAttribute' => ['employee_id', 'phone_id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::class, 'targetAttribute' => ['employee_id' => 'id']],
            [['phone_id'], 'exist', 'skipOnError' => true, 'targetClass' => Phone::class, 'targetAttribute' => ['phone_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'employee_id' => Yii::t('app', 'Employee ID'),
            'phone_id' => Yii::t('app', 'Phone ID'),
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
     * Gets query for [[Phone]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhone()
    {
        return $this->hasOne(Phone::class, ['id' => 'phone_id']);
    }
}
