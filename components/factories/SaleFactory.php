<?php

namespace app\components\factories;

use app\models\Sale;

class SaleFactory
{
    public static function create($attributes)
    {
        $sale = new Sale();
        $sale->attributes = $attributes;
        $sale->save();

        return $sale;
    }
}