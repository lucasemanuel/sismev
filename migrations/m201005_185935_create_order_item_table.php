<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_item}}`.
 */
class m201005_185935_create_order_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_item}}', [
            'id' => $this->primaryKey()->unsigned(),
            'amount' => $this->decimal(10,2)->notNull(),
            'unit_price' => $this->decimal(10,2)->notNull(),
            'order_id' => $this->integer()->unsigned()->notNull(),
            'product_id' => $this->integer()->unsigned()->notNull(),
        ]);

        $this->addForeignKey('fk-pay-order_id', 'order_item', 'order_id', 'order', 'id', 'CASCADE');
        $this->addForeignKey('fk-pay-product_id', 'order_item', 'product_id', 'product', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-pay-order_id', 'order_item');
        $this->dropForeignKey('fk-pay-product_id', 'order_item');
        $this->dropTable('{{%order_item}}');
    }
}
