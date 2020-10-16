<?php

use yii\db\Migration;

/**
 * Class m201016_130100_add_employee_id_sale
 */
class m201016_130100_add_employee_id_sale extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('sale', 'employee_id', $this->integer()->unsigned()->notNull()->after('updated_at'));
        $this->addForeignKey('fk-sale-employee_id', 'sale', 'employee_id', 'employee', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-sale-employee_id', 'sale');
        $this->dropColumn('sale', 'employee_id');
    }
}
