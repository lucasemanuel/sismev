<?php

use yii\db\Migration;

/**
 * Class m200913_205947_add_is_paid_expense
 */
class m200913_205947_add_is_paid_expense extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('expense', 'is_paid', $this->tinyInteger(1)->defaultValue(0)->after('payday'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('expense', 'is_paid');
        return false;
    }
}
