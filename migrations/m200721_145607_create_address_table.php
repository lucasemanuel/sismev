<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%address}}`.
 */
class m200721_145607_create_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%address}}', [
            'id' => $this->primaryKey()->unsigned(),
            'zip_code' => $this->string(9)->notNull(),
            'number' => $this->string(8)->notNull(),
            'street' => $this->string(64)->notNull(),
            'neighborhood' => $this->string(64)->notNull(),
            'city' => $this->string(64)->notNull(),
            'federated_unit' => $this->string(2)->notNull(),
            'complement' => $this->string(128)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%address}}');
    }
}
