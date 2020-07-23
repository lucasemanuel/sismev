<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%variation_set}}`.
 */
class m200721_145616_create_variation_set_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%variation_set}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(64)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
            'category_id' => $this->integer()->unsigned()->notNull()
        ]);

        $this->addForeignKey('fk-variation_set-category_id', 'variation_set', 'category_id', 'category', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-variation_set-category_id', 'variation_set');
        $this->dropTable('{{%variation_set}}');
    }
}
