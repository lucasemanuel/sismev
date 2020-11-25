<?php

namespace app\components\formatters;

use NumberFormatter;
use Yii;
use yii\i18n\Formatter;

class AppFormatter extends Formatter
{
    public function asDateTimeDefault($value)
    {
        if ($value === null)     
            return $this->nullDisplay;

        $value = explode(" ", $value);
        $value[0] = $this->asDateDefault($value[0]);
        return implode(" ", $value);
    }

    public function asDateDefault($value)
    {
        if ($value === null)     
            return $this->nullDisplay;

        return implode("-",array_reverse(explode("/", $value)));
    }

    public function asInputOrOutput($value)
    {
        return $value == 0 
            ? Yii::t('app', 'Output') 
            : Yii::t('app', 'Input');
    }

    public function asAmount($value)
    {
        if ($value === null)     
            return $this->nullDisplay;
        else if (empty($value))
            $value = 0;
    
        return number_format($value, 2, ',', '.');
    }

    public function asActive($value)
    {
        return $value
            ? Yii::t('app', 'No') 
            : Yii::t('app', 'Yes');
    }

    public function getCurrencySymbol()
    {
        $formatter = new NumberFormatter($this->locale, NumberFormatter::CURRENCY);
        return $formatter->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
    }
}