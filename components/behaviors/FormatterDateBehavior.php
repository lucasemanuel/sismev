<?php

namespace app\components\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class FormatterDateBehavior extends Behavior
{
    public $attributes;

    public const FORMAT_DATETIME = 'datetime';
    public const FORMAT_DATE = 'date';
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'formatter',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'formatter'
        ];
    }

    public function formatter()
    {
        $formatter = Yii::$app->formatter;
        
        foreach ($this->attributes as $attr => $format) {
            $date = $this->owner->$attr;
            if ($format == self::FORMAT_DATETIME)
                $date = $formatter->asDateTimeDefault($date);
            else if ($format == self::FORMAT_DATE)
                $date = $formatter->asDateDefault($date);
            $this->owner->$attr = $date;            
        }
    }
}