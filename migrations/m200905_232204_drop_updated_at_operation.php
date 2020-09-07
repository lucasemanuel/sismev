<?php

use yii\db\Migration;

/**
 * Class m200905_232204_drop_updated_at_operation
 */
class m200905_232204_drop_updated_at_operation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('operation', 'updated_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('operations', 'updated_at', $this->dateTime()->after('created_at'));
    }
}
