<?php

namespace app\components\formatters;

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
}