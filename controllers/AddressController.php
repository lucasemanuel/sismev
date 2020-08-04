<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class AddressController extends Controller
{
    public function actionZipcode($code)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

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
