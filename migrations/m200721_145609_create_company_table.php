<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%company}}`.
 */
class m200721_145609_create_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%company}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(64)->notNull(),
            'trade_name' => $this->string(64),
            'ein' => $this->string(18)->notNull(),
            'phone_number' => $this->string(16)->notNull(),
            'email' => $this->string(64)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
            'address_id' => $this->integer()->unsigned(),
        ]);

        $this->addForeignKey('fk-company-address_id', 'company', 'address_id', 'address', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-company-address_id', 'company');
        $this->dropTable('{{%company}}');
    }
}
