<?php

namespace app\commands;

use app\rbac\UpdateOnwer;
use app\rbac\UserGroupRule;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Create Rule
        $user_group = new UserGroupRule;
        $auth->add($user_group);
        $update_owner = new UpdateOnwer; 
        $auth->add($update_owner);

        // Create Permissions
        $update_employee = $auth->createPermission('update_employee');
        $update_employee->description = 'Update Employee';
        $update_employee->ruleName = $update_owner->name;
        $auth->add($update_employee);

        // Create Roles
        $admin = $auth->createRole('admin');
        $admin->ruleName = $user_group->name;
        $cashier = $auth->createRole('cashier');
        $cashier->ruleName = $user_group->name;
        $auth->add($admin);
        $auth->add($cashier);

        // Chinding
        $auth->addChild($cashier, $update_employee);
        $auth->addChild($admin, $cashier);
    }

    private function addPermissions($permissions)
    {
        $auth = Yii::$app->authManager;

        foreach ($permissions as $key => $value) {
            $permission = $auth->createPermission($key);
            $permission->description = $value;
            $auth->add($permission);
            $permissions[$key] = $permission;
        }

        return $permissions;
    }

    private function childingPermissions($role, $permissions)
    {
        $auth = Yii::$app->authManager;

        foreach ($permissions as $key => $permission) {
            $auth->addChild($role, $permission);
        }
    }
}