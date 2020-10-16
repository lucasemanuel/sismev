<?php

namespace app\modules\api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class AddressController extends Controller
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
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['cashier']
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($code)
    {
        if (preg_match('/\d{8}/', $code)) {
            $url = 'http://viacep.com.br/ws/' . $code . '/json';
            $response = json_decode(file_get_contents($url));

            if (!isset($response->erro)) {
                return [
                    'federated_unit' => $response->uf,
                    'city' => $response->localidade,
                    'neighborhood' => $response->bairro,
                    'street' => $response->logradouro,
                    'complement' => $response->complemento,
                    'zip_code' => $code
                ];
            }
        }

        throw new BadRequestHttpException(Yii::t('app', 'Zip code does not exist, try again with another zip code.'));
    }
}
