<?php

namespace app\components\traits;

use Yii;

trait FilterTrait
{
    public static function find()
    {
        $find = parent::find();

        if (!Yii::$app->user->getIsGuest()) {
            if (self::isJoinsSet())
                self::makeInnerJoin($find);

            $find->andWhere(['company.id' => Yii::$app->user->identity->company_id]);
        }

        return $find;
    }

    protected function isJoinsSet()
    {
        return !empty(self::JOINS) && is_array(self::JOINS);
    } 

    protected function makeInnerJoin(&$find)
    {
        foreach(self::JOINS as $join)
            $find->innerJoin($join['table'], $join['on']);
    }
}