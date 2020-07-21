<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%expense}}`.
 */
class m200721_145612_create_expense_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%expense}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(64)->notNull(),
            'description' => $this->text(),
            'value' => $this->decimal(10,2)->notNull(),
            'payday' => $this->date()->notNull(),
            'paid_at' => $this->dateTime(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
            'company_id' => $this->integer()->unsigned()->notNull(),
        ]);

        $this->addForeignKey('fk-expense-company_id', 'expense', 'company_id', 'company', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-expense-company_id', 'expense');
        $this->dropTable('{{%expense}}');
    }
}
