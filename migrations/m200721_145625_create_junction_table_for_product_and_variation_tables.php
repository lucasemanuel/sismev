<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_variation}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%product}}`
 * - `{{%variation}}`
 */
class m200721_145625_create_junction_table_for_product_and_variation_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_variation}}', [
            'product_id' => $this->integer()->unsigned(),
            'name' => $this->string(64)->notNull(),
            'variation_id' => $this->integer()->unsigned(),
            'PRIMARY KEY(product_id, variation_id)',
        ]);

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-product_variation-product_id}}',
            '{{%product_variation}}',
            'product_id'
        );

        // add foreign key for table `{{%product}}`
        $this->addForeignKey(
            '{{%fk-product_variation-product_id}}',
            '{{%product_variation}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );

        // creates index for column `variation_id`
        $this->createIndex(
            '{{%idx-product_variation-variation_id}}',
            '{{%product_variation}}',
            'variation_id'
        );

        // add foreign key for table `{{%variation}}`
        $this->addForeignKey(
            '{{%fk-product_variation-variation_id}}',
            '{{%product_variation}}',
            'variation_id',
            '{{%variation}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%product}}`
        $this->dropForeignKey(
            '{{%fk-product_variation-product_id}}',
            '{{%product_variation}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-product_variation-product_id}}',
            '{{%product_variation}}'
        );

        // drops foreign key for table `{{%variation}}`
        $this->dropForeignKey(
            '{{%fk-product_variation-variation_id}}',
            '{{%product_variation}}'
        );

        // drops index for column `variation_id`
        $this->dropIndex(
            '{{%idx-product_variation-variation_id}}',
            '{{%product_variation}}'
        );

        $this->dropTable('{{%product_variation}}');
    }
}
