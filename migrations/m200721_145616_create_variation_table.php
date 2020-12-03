<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%variation}}`.
 */
class m200721_145616_create_variation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%variation}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(64)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
            'category_id' => $this->integer()->unsigned()->notNull()
        ]);

        $this->addForeignKey('fk-variation-category_id', 'variation', 'category_id', 'category', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-variation-category_id', 'variation');
        $this->dropTable('{{%variation}}');
    }
}
