<?php

namespace app\modules\api\controllers;

use app\modules\api\models\ProductSearch;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\Response;

class ProductController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['query'],
                        'allow' => true,
                        'roles' => ['cashier']
                    ],
                ],
            ],
        ];
    }

    public function actionQuery($q = null, $id = null)
    {
        $out = ['results' => ['id' => '', 'name' => '', 'price' => '']];

        if (!is_null($q)) {
            $data = ProductSearch::findInNameWithVariation(trim($q));
            $out['results'] = array_map(function($product) {
                return $product->toArray();
            }, array_values($data));
        }
        return $out;
    }
}