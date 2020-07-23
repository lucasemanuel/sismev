<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company_phone".
 *
 * @property int $company_id
 * @property int $phone_id
 *
 * @property Company $company
 * @property Phone $phone
 */
class CompanyPhone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_phone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'phone_id'], 'required'],
            [['company_id', 'phone_id'], 'integer'],
            [['company_id', 'phone_id'], 'unique', 'targetAttribute' => ['company_id', 'phone_id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
            [['phone_id'], 'exist', 'skipOnError' => true, 'targetClass' => Phone::class, 'targetAttribute' => ['phone_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'company_id' => Yii::t('app', 'Company ID'),
            'phone_id' => Yii::t('app', 'Phone ID'),
        ];
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
     * Gets query for [[Phone]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhone()
    {
        return $this->hasOne(Phone::class, ['id' => 'phone_id']);
    }
}
