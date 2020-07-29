<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_product}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%order}}`
 * - `{{%product}}`
 */
class m200721_145626_create_junction_table_for_order_and_product_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_product}}', [
            'amount' => $this->decimal(10,2)->notNull(),
            'unit_price' => $this->decimal(10,2)->notNull(),
            'PRIMARY KEY(order_id, product_id)',
        ]);

        // creates index for column `order_id`
        $this->createIndex(
            '{{%idx-order_product-order_id}}',
            '{{%order_product}}',
            'order_id'
        );

        // add foreign key for table `{{%order}}`
        $this->addForeignKey(
            '{{%fk-order_product-order_id}}',
            '{{%order_product}}',
            'order_id',
            '{{%order}}',
            'id',
            'CASCADE'
        );

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-order_product-product_id}}',
            '{{%order_product}}',
            'product_id'
        );

        // add foreign key for table `{{%product}}`
        $this->addForeignKey(
            '{{%fk-order_product-product_id}}',
            '{{%order_product}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%order}}`
        $this->dropForeignKey(
            '{{%fk-order_product-order_id}}',
            '{{%order_product}}'
        );

        // drops index for column `order_id`
        $this->dropIndex(
            '{{%idx-order_product-order_id}}',
            '{{%order_product}}'
        );

        // drops foreign key for table `{{%product}}`
        $this->dropForeignKey(
            '{{%fk-order_product-product_id}}',
            '{{%order_product}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-order_product-product_id}}',
            '{{%order_product}}'
        );

        $this->dropTable('{{%order_product}}');
    }
}
