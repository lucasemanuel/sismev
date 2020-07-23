<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sale}}`.
 */
class m200721_145621_create_sale_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sale}}', [
            'id' => $this->primaryKey()->unsigned(),
            'amount_paid' => $this->decimal(10,2),
            'discount' => $this->decimal(10,2),
            'sale_at' => $this->dateTime(),
            'canceled_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'order_id' => $this->integer()->unsigned()->notNull()
        ]);

        $this->addForeignKey('fk-sale-order_id', 'sale', 'order_id', 'order', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-sale-order_id', 'sale');
        $this->dropTable('{{%sale}}');
    }
}
