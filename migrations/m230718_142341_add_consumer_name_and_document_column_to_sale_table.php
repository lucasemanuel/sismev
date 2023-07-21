<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sale}}`.
 */
class m230718_142341_add_consumer_name_and_document_column_to_sale_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sale}}', 'consumer_name', $this->string(32)->unsigned()->after('is_canceled'));
        $this->addColumn('{{%sale}}', 'consumer_document', $this->string(18)->unsigned()->after('consumer_name'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sale}}', 'consumer_document');
        $this->dropColumn('{{%sale}}', 'consumer_name');
    }
}
