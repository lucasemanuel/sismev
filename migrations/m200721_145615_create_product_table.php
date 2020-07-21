<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m200721_145615_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey()->unsigned(),
            'code' => $this->string(32)->notNull(),
            'name' => $this->string(64)->notNull(),
            'unit_price' => $this->decimal(10,2)->notNull(),
            'amount' => $this->decimal(10,2)->notNull(),
            'max_amount' => $this->decimal(10,2)->notNull(),
            'min_amount' => $this->decimal(10,2)->notNull(),
            'is_deleted' => $this->tinyInteger(1)->defaultValue(0),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
            'category_id' => $this->integer()->unsigned()->notNull()
        ]);

        $this->addForeignKey('fk-product-category_id', 'product', 'category_id', 'category', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-product-category_id', 'product');
        $this->dropTable('{{%product}}');
    }
}
