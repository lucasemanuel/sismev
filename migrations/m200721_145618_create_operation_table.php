<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%operation}}`.
 */
class m200721_145618_create_operation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%operation}}', [
            'id' => $this->primaryKey()->unsigned(),
            'in_out' => $this->tinyInteger(1)->notNull(),
            'amount' => $this->decimal(10,2)->notNull(),
            'reason' => $this->string(64)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
            'product_id' => $this->integer()->unsigned()->notNull(),
        ]);

        $this->addForeignKey('fk-operation-product_id', 'operation', 'product_id', 'product', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-operation-product_id', 'operation');
        $this->dropTable('{{%operation}}');
    }
}
