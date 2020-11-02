<?php

use yii\db\Migration;

/**
 * Class m201102_181500_drop_note_and_is_quotation_order
 */
class m201102_181500_drop_note_and_is_quotation_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('order', 'note');
        $this->dropColumn('order', 'is_quotation');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('order', 'note', $this->text());
        $this->addColumn('order', 'is_quotation', $this->tinyInteger(1)->defaultValue(0));
    }
}
