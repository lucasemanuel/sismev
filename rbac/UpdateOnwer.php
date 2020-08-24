<?php

namespace app\rbac;

use Yii;
use yii\rbac\Rule;

class UpdateOnwer extends Rule
{
    public $name = 'update_owner';

    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->is_manager)
            return true;
            
        return isset($params['employee_id']) ? $params['employee_id'] == $user : false;
    }    
}