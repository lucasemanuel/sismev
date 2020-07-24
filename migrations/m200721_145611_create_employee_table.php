<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%employee}}`.
 */
class m200721_145611_create_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%employee}}', [
            'id' => $this->primaryKey()->unsigned(),
            'full_name' => $this->string(128)->notNull(),
            'usual_name' => $this->string(32)->notNull(),
            'ssn' => $this->string(12)->notNull(),
            'birthday' => $this->date()->notNull(),
            'email' => $this->string(64)->notNull(),
            'password' => $this->string(255)->notNull(),
            'is_manager' => $this->tinyInteger(1)->defaultValue(0),
            'is_deleted' => $this->tinyInteger(1)->defaultValue(0),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
            'address_id' => $this->integer()->unsigned(),
            'company_id' => $this->integer()->unsigned()->notNull(),
        ]);

        $this->addForeignKey('fk-employee-address_id', 'employee', 'address_id', 'address', 'id', 'CASCADE');
        $this->addForeignKey('fk-employee-company_id', 'employee', 'company_id', 'company', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-employee-address_id', 'employee');
        $this->dropForeignKey('fk-employee-company_id', 'employee');
        $this->dropTable('{{%employee}}');
    }
}
