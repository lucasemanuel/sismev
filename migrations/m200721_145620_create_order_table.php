<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m200721_145620_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey()->unsigned(),
            'code' => $this->string(20)->notNull(),
            'total_value' => $this->decimal(10,2),
            'note' => $this->text(),
            'is_quotation' => $this->tinyInteger(1)->defaultValue(0),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
            'company_id' => $this->integer()->unsigned()->notNull()
        ]);

        $this->addForeignKey('fk-order-company_id', 'order', 'company_id', 'company', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-order-company_id', 'order');
        $this->dropTable('{{%order}}');
    }
}
