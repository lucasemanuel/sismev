<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pay}}`.
 */
class m200721_145622_create_pay_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pay}}', [
            'id' => $this->primaryKey()->unsigned(),
            'value' => $this->decimal(10,2)->notNull(),
            'installments' => $this->smallInteger()->unsigned(),
            'payment_method_id' => $this->integer()->unsigned()->notNull(),
            'sale_id' => $this->integer()->unsigned()->notNull(),
        ]);

        $this->addForeignKey('fk-pay-payment_method_id', 'pay', 'payment_method_id', 'payment_method', 'id', 'CASCADE');
        $this->addForeignKey('fk-pay-sale_id', 'pay', 'sale_id', 'sale', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-pay-payment_method_id', 'pay');
        $this->dropForeignKey('fk-pay-sale_id', 'pay');
        $this->dropTable('{{%pay}}');
    }
}
