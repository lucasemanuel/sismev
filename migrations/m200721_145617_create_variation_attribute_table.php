<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%variation_attribute}}`.
 */
class m200721_145617_create_variation_attribute_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%variation_attribute}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(64)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
            'variation_set_id' => $this->integer()->unsigned()->notNull(),
        ]);

        $this->addForeignKey('fk-variation_attribute-variation_set_id', 'variation_attribute', 'variation_set_id', 'variation_set', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-variation_attribute-variation_set_id', 'variation_attribute');
        $this->dropTable('{{%variation_attribute}}');
    }
}
