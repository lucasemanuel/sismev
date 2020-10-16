<?php

namespace app\components\validators;

use yii\validators\NumberValidator;

class DecimalValidator extends NumberValidator
{
    const MAX = 99999999.99;
    
    public $max = self::MAX;
    public $min = 00.01;
}