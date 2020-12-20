<?php

namespace app\models;

use app\components\behaviors\FormatterDateBehavior;
use app\components\traits\FilterTrait;
use Yii;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string $full_name
 * @property string $usual_name
 * @property string $ssn
 * @property string $birthday
 * @property string $phone_number 
 * @property string $email
 * @property string $password
 * @property int|null $is_manager
 * @property int|null $is_deleted
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $address_id
 * @property int $company_id
 *
 * @property Address $address
 * @property Company $company
 * @property Operation[] $operations 
 * @property Sale[] $sales 
 */
class Employee extends ActiveRecord implements IdentityInterface
{
    use FilterTrait;

    const JOINS = [
        [
            'table' => 'company',
            'on' => 'employee.company_id = company.id'
        ]
    ];
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_SIGNUP = 'signup';
    const SCENARIO_CREATE = 'create';
    const SCENARIO_CHANGE_PASSWORD = 'change_password';

    public $password_repeat;
    public $password_new;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at'],
                    self::EVENT_BEFORE_UPDATE => ['created_at', 'updated_at'],
                    SoftDeleteBehavior::EVENT_BEFORE_SOFT_DELETE => ['deleted_at']
                ]
            ],
            'formatterDateBehavior' => [
                'class' => FormatterDateBehavior::class,
                'attributes' => [
                    'birthday' => FormatterDateBehavior::FORMAT_DATE
                ]
            ],
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::class,
                'softDeleteAttributeValues' => [
                    'is_deleted' => true
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'usual_name', 'ssn', 'birthday', 'email', 'password', 'company_id', 'phone_number', 'password_repeat'], 'required'],
            [['password_new'], 'required', 'on' => self::SCENARIO_CHANGE_PASSWORD],
            [['password'], function ($attribute, $params, $validator) {
                if (!Yii::$app->getSecurity()->validatePassword($this->password, $this->oldAttributes['password'])) {
                    $this->addError($attribute, Yii::t('app', 'The password must be the same as the current one.'));
                }
            }, 'on' => self::SCENARIO_CHANGE_PASSWORD],
            [['birthday', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_at'], 'default', 'value' => null],
            [['is_manager', 'is_deleted', 'address_id', 'company_id'], 'integer'],
            [['full_name'], 'string', 'max' => 128],
            [['usual_name'], 'string', 'max' => 32],
            [['ssn'], 'string', 'max' => 14],
            [['email'], 'string', 'max' => 64],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['password', 'password_new'], 'string', 'max' => 255],
            [['password', 'password_new'], 'string', 'min' => 6],
            [['is_manager'], 'default', 'value' => 0],
            [['is_deleted'], 'default', 'value' => 0],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password', 'on' => self::SCENARIO_SIGNUP, 'except' => self::SCENARIO_CHANGE_PASSWORD],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password_new', 'on' => self::SCENARIO_CHANGE_PASSWORD],
            [['phone_number'], 'match', 'pattern' => '/(\(\d{2}\)\ \d{4,5}\-\d{4})/'],
            [['ssn'], 'match', 'pattern' => '/(\d{3}\.\d{3}\.\d{3}\-\d{2})/'],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::class, 'targetAttribute' => ['address_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SIGNUP] = ['full_name', 'usual_name', 'ssn', 'birthday', 'email', 'password', 'password_repeat', 'phone_number'];
        $scenarios[self::SCENARIO_CREATE] = ['full_name', 'usual_name', 'ssn', 'birthday', 'email', 'password', 'password_repeat', 'phone_number', 'is_manager'];
        $scenarios[self::SCENARIO_UPDATE] = array_filter($scenarios[self::SCENARIO_DEFAULT], function ($attribute) {
            return !in_array($attribute, ['password', 'password_repeat', 'password_new']);
        });
        $scenarios[self::SCENARIO_CHANGE_PASSWORD] = ['password', 'password_repeat', 'password_new'];

        return $scenarios;
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
            'is_deleted' => Yii::t('app', 'Active'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'address_id' => Yii::t('app', 'Address'),
            'company_id' => Yii::t('app', 'Company'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'password_repeat' => Yii::t('app', 'Password Repeat'),
            'password_new' => Yii::t('app', 'New Password'),
        ];
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return null;
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        $user = self::findOne(['email' => $email]);

        if ($user) return new static($user);

        return null;
    }

    public function validatePassword($hash)
    {
        return Yii::$app->getSecurity()->validatePassword($hash, $this->password);
    }

    public function beforeSave($insert)
    {
        $this->encryptingPassword();
        return parent::beforeSave($insert);
    }

    private function encryptingPassword()
    {

        if ($this->isNewPassword()) {
            $hash = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            $this->password = $hash;
        }
    }

    private function isNewPassword()
    {
        return empty($this->oldAttributes) || ($this->oldAttributes['password'] != $this->password);
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
     * Gets query for [[Operations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOperations()
    {
        return $this->hasMany(Operation::class, ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[Sales]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSales()
    {
        return $this->hasMany(Sale::class, ['employee_id' => 'id']);
    }

    public function __toString()
    {
        return $this->full_name;
    }
}
