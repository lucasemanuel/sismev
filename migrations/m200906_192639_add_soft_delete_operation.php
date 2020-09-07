<?php

use yii\db\Migration;

/**
 * Class m200906_192639_add_soft_delete_operation
 */
class m200906_192639_add_soft_delete_operation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('operation', 'deleted_at', $this->dateTime()->after('created_at'));
        $this->addColumn('operation', 'is_deleted', $this->tinyInteger(1)->defaultValue(0)->after('deleted_at'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('operation', 'deleted_at');
        $this->dropColumn('operation', 'is_deleted');
        return false;
    }
}
