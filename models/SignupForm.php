<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Signup is the model behind the Sign Up form.
 */
class SignupForm extends Model
{
    const SCENARIO_COMPANY = "company";
    const SCENARIO_EMPLOYEE = "employee";

    const STEP_ONE = '1';
    const STEP_TWO = '2';

    public $step = 1;
    public $name;
    public $trade_name;
    public $ein;
    public $email;
    public $full_name;
    public $usual_name;
    public $ssn;
    public $birthday;
    public $password;

    public function rules()
    {
        return [
            [['name', 'ein', 'email', 'step', 'full_name', 'usual_name', 'ssn', 'birthday', 'password'], 'required'],
            [['password'], 'string', 'max' => 255],
            [['full_name'], 'string', 'max' => 128],
            [['name', 'trade_name', 'email'], 'string', 'max' => 64],
            [['usual_name'], 'string', 'max' => 32],
            [['ein'], 'string', 'max' => 18],
            [['ssn'], 'string', 'max' => 12],
            [['email'], 'email'],
            [['birthday', 'step'], 'safe'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_COMPANY] = ['name', 'ein', 'email', 'trade_name', 'step'];
        $scenarios[self::SCENARIO_EMPLOYEE] = ['full_name', 'usual_name', 'ssn', 'birthday', 'email', 'password', 'step'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            // Company
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'trade_name' => Yii::t('app', 'Trade Name'),
            'ein' => Yii::t('app', 'Ein'),
            'email' => Yii::t('app', 'Email'),

            // Employee
            'full_name' => Yii::t('app', 'Full Name'),
            'usual_name' => Yii::t('app', 'Usual Name'),
            'ssn' => Yii::t('app', 'Ssn'),
            'birthday' => Yii::t('app', 'Birthday'),
            'password' => Yii::t('app', 'Password'),
        ];
    }

}
