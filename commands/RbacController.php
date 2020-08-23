<?php

namespace app\commands;

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

        // Create Roles
        $admin = $auth->createRole('admin');
        $admin->ruleName = $user_group->name;
        $cashier = $auth->createRole('cashier');
        $cashier->ruleName = $user_group->name;
        $auth->add($admin);
        $auth->add($cashier);

        // Chinding
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