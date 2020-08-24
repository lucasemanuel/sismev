<?php

namespace app\rbac;

use Yii;
use yii\rbac\Rule;

class UserGroupRule extends Rule
{
    public $name = 'user_group';

    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {
            $is_manager = Yii::$app->user->identity->is_manager;
            if ($item->name === 'admin')
                return $is_manager == 1;
            else if ($item->name === 'cashier')
                return $is_manager == 1 || $is_manager == 0;
        }
        
        return false;
    }    
}