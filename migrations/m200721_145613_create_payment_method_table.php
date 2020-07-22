<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment_method}}`.
 */
class m200721_145613_create_payment_method_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment_method}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(64)->notNull(),
            'installment_limit' => $this->tinyInteger()->unsigned()->notNull(),
            'is_deleted' => $this->tinyInteger(1)->defaultValue(0),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
            'company_id' => $this->integer()->unsigned()->notNull(),
        ]);

        $this->addForeignKey('fk-payment_method-company_id', 'payment_method', 'company_id', 'company', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-payment_method-company_id', 'payment_method');
        $this->dropTable('{{%payment_method}}');
    }
}
