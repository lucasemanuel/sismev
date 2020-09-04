<?php

namespace app\components\traits;

trait UpdateCountersTrait
{
    public function updateCounters($counters)
    {
        if (parent::updateAllCounters($counters, $this->getOldPrimaryKey(true)) > 0) {
            foreach ($counters as $name => $value) {
                $this->$name = !isset($this->$name) ? $value: $this->$name += $value;
                $this->update();
            }
            return true;
        }
        return false;
    }
}