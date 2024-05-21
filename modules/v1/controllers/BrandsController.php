<?php

namespace app\modules\v1\controllers;

use Yii;
use app\models\BrandDetails;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\base\Exception;

class BrandsController extends ActiveController
{
    public $modelClass  = 'app\models\BrandDetails';
    public $api_response    = ['status' => 0, 'msg' => 'Invalid Request', 'token' => '', 'data' => ''];

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['get-brands'],
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'get-brands' => ['GET']
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    //all brands list
    public function actionGetBrands()
    {
        try {
            $headers = \Yii::$app->request->headers;
            $token = $headers->get('authorization');
            $eduId = \Yii::$app->api->validateAuthToken($token, 'get-brands');
            // $body = json_decode(file_get_contents("php://input"), true);
            // $data = \Yii::$app->api->jwtDecodeBody($body['data']);
            //$category_id = ($data['category_id']) ? $data['category_id'] : 0;
            $find = ['status' => 1];
            // if ($category_id != 0) {
            //     $find['category_id'] = $category_id;
            // }
            Yii::$app->response->content = 'Data synced.';
            return BrandDetails::find($find)->select(['id', 'brand_name as name', 'category_id'])->asArray()->all();
        } catch (Exception $e) {
            Yii::$app->response->statusCode = $e->statusCode;
            return ['status' => 'error', 'code' => $e->statusCode, 'name' => $e->getMessage()];
        }
    }
}
