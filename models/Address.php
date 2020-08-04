<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property int $id
 * @property string $zip_code
 * @property string $number
 * @property string $street
 * @property string $neighborhood
 * @property string $city
 * @property string $federated_unit
 * @property string $complement
 *
 * @property Company[] $companies
 * @property Employee[] $employees
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zip_code', 'number', 'street', 'neighborhood', 'city', 'federated_unit'], 'required'],
            [['zip_code'], 'string', 'max' => 8],
            [['number'], 'string', 'max' => 8],
            [['street', 'neighborhood', 'city'], 'string', 'max' => 64],
            [['federated_unit'], 'string', 'max' => 2],
            [['zip_code'], 'match', 'pattern' => '/\d{8}/'],
            [['complement'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'zip_code' => Yii::t('app', 'Zip Code'),
            'number' => Yii::t('app', 'Number'),
            'street' => Yii::t('app', 'Street'),
            'neighborhood' => Yii::t('app', 'Neighborhood'),
            'city' => Yii::t('app', 'City'),
            'federated_unit' => Yii::t('app', 'Federated Unit'),
            'complement' => Yii::t('app', 'Complement'),
        ];
    }

    /**
     * Gets query for [[Companies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::class, ['address_id' => 'id']);
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employee::class, ['address_id' => 'id']);
    }
}
