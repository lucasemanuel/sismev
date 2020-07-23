<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "expense".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property float $value
 * @property string $payday
 * @property string|null $paid_at
 * @property string $created_at
 * @property string|null $updated_at
 * @property int $company_id
 *
 * @property Company $company
 */
class Expense extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'expense';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'value', 'payday', 'created_at', 'company_id'], 'required'],
            [['description'], 'string'],
            [['value'], 'number'],
            [['payday', 'paid_at', 'created_at', 'updated_at'], 'safe'],
            [['company_id'], 'integer'],
            [['name'], 'string', 'max' => 64],
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
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'value' => Yii::t('app', 'Value'),
            'payday' => Yii::t('app', 'Payday'),
            'paid_at' => Yii::t('app', 'Paid At'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'company_id' => Yii::t('app', 'Company ID'),
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
}
