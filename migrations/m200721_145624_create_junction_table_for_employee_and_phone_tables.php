<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%employee_phone}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%employee}}`
 * - `{{%phone}}`
 */
class m200721_145624_create_junction_table_for_employee_and_phone_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%employee_phone}}', [
            'employee_id' => $this->integer()->unsigned(),
            'phone_id' => $this->integer()->unsigned(),
            'PRIMARY KEY(employee_id, phone_id)',
        ]);

        // creates index for column `employee_id`
        $this->createIndex(
            '{{%idx-employee_phone-employee_id}}',
            '{{%employee_phone}}',
            'employee_id'
        );

        // add foreign key for table `{{%employee}}`
        $this->addForeignKey(
            '{{%fk-employee_phone-employee_id}}',
            '{{%employee_phone}}',
            'employee_id',
            '{{%employee}}',
            'id',
            'CASCADE'
        );

        // creates index for column `phone_id`
        $this->createIndex(
            '{{%idx-employee_phone-phone_id}}',
            '{{%employee_phone}}',
            'phone_id'
        );

        // add foreign key for table `{{%phone}}`
        $this->addForeignKey(
            '{{%fk-employee_phone-phone_id}}',
            '{{%employee_phone}}',
            'phone_id',
            '{{%phone}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%employee}}`
        $this->dropForeignKey(
            '{{%fk-employee_phone-employee_id}}',
            '{{%employee_phone}}'
        );

        // drops index for column `employee_id`
        $this->dropIndex(
            '{{%idx-employee_phone-employee_id}}',
            '{{%employee_phone}}'
        );

        // drops foreign key for table `{{%phone}}`
        $this->dropForeignKey(
            '{{%fk-employee_phone-phone_id}}',
            '{{%employee_phone}}'
        );

        // drops index for column `phone_id`
        $this->dropIndex(
            '{{%idx-employee_phone-phone_id}}',
            '{{%employee_phone}}'
        );

        $this->dropTable('{{%employee_phone}}');
    }
}
