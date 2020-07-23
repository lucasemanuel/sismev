<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%company_phone}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%company}}`
 * - `{{%phone}}`
 */
class m200721_145623_create_junction_table_for_company_and_phone_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%company_phone}}', [
            'company_id' => $this->integer()->unsigned(),
            'phone_id' => $this->integer()->unsigned(),
            'PRIMARY KEY(company_id, phone_id)',
        ]);

        // creates index for column `company_id`
        $this->createIndex(
            '{{%idx-company_phone-company_id}}',
            '{{%company_phone}}',
            'company_id'
        );

        // add foreign key for table `{{%company}}`
        $this->addForeignKey(
            '{{%fk-company_phone-company_id}}',
            '{{%company_phone}}',
            'company_id',
            '{{%company}}',
            'id',
            'CASCADE'
        );

        // creates index for column `phone_id`
        $this->createIndex(
            '{{%idx-company_phone-phone_id}}',
            '{{%company_phone}}',
            'phone_id'
        );

        // add foreign key for table `{{%phone}}`
        $this->addForeignKey(
            '{{%fk-company_phone-phone_id}}',
            '{{%company_phone}}',
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
        // drops foreign key for table `{{%company}}`
        $this->dropForeignKey(
            '{{%fk-company_phone-company_id}}',
            '{{%company_phone}}'
        );

        // drops index for column `company_id`
        $this->dropIndex(
            '{{%idx-company_phone-company_id}}',
            '{{%company_phone}}'
        );

        // drops foreign key for table `{{%phone}}`
        $this->dropForeignKey(
            '{{%fk-company_phone-phone_id}}',
            '{{%company_phone}}'
        );

        // drops index for column `phone_id`
        $this->dropIndex(
            '{{%idx-company_phone-phone_id}}',
            '{{%company_phone}}'
        );

        $this->dropTable('{{%company_phone}}');
    }
}
