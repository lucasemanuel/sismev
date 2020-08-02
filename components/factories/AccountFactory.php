<?php

namespace app\components\factories;

use app\models\Company;
use app\models\Employee;
use yii\db\Exception;
use Yii;

class AccountFactory
{
    public static function create($company, $employee)
    {
        $trasaction = Yii::$app->getDb()->beginTransaction();
        
        try {
            $company = self::createCompany($company);
            $employee['company_id'] = $company->id;
            self::createEmployee($employee);

            $trasaction->commit();
        } catch (Exception $e) {
            $trasaction->rollBack();
            throw $e;
        }
    }

    private static function createCompany($attributes)
    {
        $company = new Company();
        $company->setAttributes($attributes);
        if (!$company->save())
            throw new Exception(Yii::t('app', 'Failed to register company.'));

        return $company;
    }

    private static function createEmployee($attributes)
    {
        $employee = new Employee();
        $employee->setAttributes($attributes);
        if (!$employee->save())
            throw new Exception(Yii::t('app', 'Failed to register your account.'));

        return $employee;
    }
}