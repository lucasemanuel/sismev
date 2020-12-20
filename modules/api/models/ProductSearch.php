<?php

namespace app\modules\api\models;

use app\models\Product;

class ProductSearch extends Product
{
    public static function findInNameWithVariation(string $term)
    {
        $query = self::find()
            ->andWhere(['is_deleted' => 0])
            ->all();
        $terms = explode(' ', $term);
        return array_filter($query, function($product) use ($terms) {
            foreach ($terms as $term) {
                $name = (string)$product;
                if (!preg_match("/{$term}/i", $name))
                    return false;
            }
            return true;
        });
    }
}
