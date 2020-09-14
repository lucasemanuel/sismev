<?php

namespace app\models;

use app\components\traits\FilterTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "expense".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property float $value
 * @property string $payday
 * @property int|null $is_paid
 * @property string|null $paid_at
 * @property string $created_at
 * @property string|null $updated_at
 * @property int $company_id
 *
 * @property Company $company
 */
class Expense extends ActiveRecord
{
    use FilterTrait;

    const JOINS = [
        [
            'table' => 'company',
            'on' => 'expense.company_id = company.id'
        ]
    ];
    const SCENARIO_PAID = 'paid';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'expense';
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
            [['name', 'value', 'payday', 'company_id'], 'required'],
            [['paid_at', 'is_paid'], 'required', 'on' => self::SCENARIO_PAID],
            [['description'], 'string'],
            [['value'], 'number', 'max' => 99999999.99, 'min' => 00.01],
            [['payday', 'paid_at', 'created_at', 'updated_at'], 'safe'],
            [['payday'], 'default', 'value' => null],
            [['company_id'], 'integer'],
            [['is_paid'], 'boolean'],
            [['is_paid'], 'default', 'value' => 0],
            [['name'], 'string', 'max' => 64],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PAID] = ['paid_at', 'is_paid'];

        return $scenarios;
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
            'is_paid' => Yii::t('app', 'Is Paid'),
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
