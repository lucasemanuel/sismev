<?php

namespace app\components;

use app\models\Operation;
use app\models\Sale;
use Yii;
use yii\base\Component;
use yii\db\Expression;
use yii\web\BadRequestHttpException;

class Seller extends Component
{
    public static function complete($event)
    {
        $sale = $event->sender;

        Sale::getDb()->transaction(function ($db) use ($sale) {
            $sale->sale_at = new Expression('NOW()');
            $sale->update();

            $items = $sale->order->OrderItems;
            self::descraseItemsStock($items);
        });
    }

    private static function descraseItemsStock($items)
    {
        foreach ($items as $item) {
            $operation = new Operation();
            $operation->attributes = [
                'in_out' => 1,
                'amount' => $item->amount,
                'reason' => Yii::t('app', 'Product sale.'),
                'product_id' => $item->product_id,
            ];

            if (!$operation->save()) {
                foreach($operation->firstErrors as $erro) break;
                throw new BadRequestHttpException($erro);        
            }
        }
    }
}