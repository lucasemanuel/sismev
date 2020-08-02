<?php

namespace app\models;

use Yii;
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
class Employee extends ActiveRecord implements IdentityInterface
{
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_SIGNUP = 'signup';
    
    public $password_repeat;

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
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'usual_name', 'ssn', 'birthday', 'email', 'password', 'company_id', 'phone_number'], 'required'],
            [['password_repeat'], 'required', 'on' => self::SCENARIO_SIGNUP],
            [['birthday', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_at'], 'default', 'value' => null],
            [['is_manager', 'is_deleted', 'address_id', 'company_id'], 'integer'],
            [['full_name'], 'string', 'max' => 128],
            [['usual_name'], 'string', 'max' => 32],
            [['ssn'], 'string', 'max' => 12],
            [['email'], 'string', 'max' => 64],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['password'], 'string', 'max' => 255],
            [['is_manager'], 'default', 'value' => 0],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password'],
            [['phone_number'], 'match', 'pattern' => '/(\(\d{2}\)\ \d{4,5}\-\d{4})/'],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::class, 'targetAttribute' => ['address_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SIGNUP] = ['full_name', 'usual_name', 'ssn', 'birthday', 'email', 'password', 'password_repeat', 'phone_number'];
        $scenarios[self::SCENARIO_UPDATE] = array_filter($scenarios[self::SCENARIO_DEFAULT], function ($attribute) {
            return $attribute != 'password';
        });

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
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'address_id' => Yii::t('app', 'Address ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'phone_number' => Yii::t('app', 'Phone Number'),
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
}
