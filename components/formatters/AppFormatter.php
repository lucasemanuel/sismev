<?php

namespace app\components\formatters;

use NumberFormatter;
use Yii;
use yii\i18n\Formatter;

class AppFormatter extends Formatter
{
    public function asDateTimeDefault($attr)
    {
        $attr = explode(" ", $attr);
        $attr[0] = $this->date($attr[0]);
        return implode(" ", $attr);
    }

    public function asDateDefault($attr)
    {
        return implode("-",array_reverse(explode("/", $attr)));
    }

    public function asInputOrOutput($value)
    {
        return $value == 0 
            ? Yii::t('app', 'Output') 
            : Yii::t('app', 'Input');
    }

    public function asAmount($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function getCurrencySymbol()
    {
        $formatter = new NumberFormatter($this->locale, NumberFormatter::CURRENCY);
        return $formatter->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
    }
}