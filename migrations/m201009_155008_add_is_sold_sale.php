<?php

use yii\db\Migration;

/**
 * Class m201009_155008_add_is_sold_sale
 */
class m201009_155008_add_is_sold_sale extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('sale', 'is_sold', $this->tinyInteger(1)->defaultValue(0)->after('discount'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('sale', 'is_sold');
    }
}
