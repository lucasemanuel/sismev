<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_variation_attribute}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%product}}`
 * - `{{%variation_attribute}}`
 */
class m200721_145625_create_junction_table_for_product_and_variation_attribute_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_variation_attribute}}', [
            'product_id' => $this->integer()->unsigned(),
            'variation_attribute_id' => $this->integer()->unsigned(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
            'PRIMARY KEY(product_id, variation_attribute_id)',
        ]);

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-product_variation_attribute-product_id}}',
            '{{%product_variation_attribute}}',
            'product_id'
        );

        // add foreign key for table `{{%product}}`
        $this->addForeignKey(
            '{{%fk-product_variation_attribute-product_id}}',
            '{{%product_variation_attribute}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );

        // creates index for column `variation_attribute_id`
        $this->createIndex(
            '{{%idx-product_variation_attribute-variation_attribute_id}}',
            '{{%product_variation_attribute}}',
            'variation_attribute_id'
        );

        // add foreign key for table `{{%variation_attribute}}`
        $this->addForeignKey(
            '{{%fk-product_variation_attribute-variation_attribute_id}}',
            '{{%product_variation_attribute}}',
            'variation_attribute_id',
            '{{%variation_attribute}}',
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
            '{{%fk-product_variation_attribute-product_id}}',
            '{{%product_variation_attribute}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-product_variation_attribute-product_id}}',
            '{{%product_variation_attribute}}'
        );

        // drops foreign key for table `{{%variation_attribute}}`
        $this->dropForeignKey(
            '{{%fk-product_variation_attribute-variation_attribute_id}}',
            '{{%product_variation_attribute}}'
        );

        // drops index for column `variation_attribute_id`
        $this->dropIndex(
            '{{%idx-product_variation_attribute-variation_attribute_id}}',
            '{{%product_variation_attribute}}'
        );

        $this->dropTable('{{%product_variation_attribute}}');
    }
}
