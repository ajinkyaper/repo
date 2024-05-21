<?php

namespace app\modules\v1\controllers;

use Yii;
use app\models\Educators;
use app\models\PinPull;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;

use yii\base\Exception;
use yii\web\UnauthorizedHttpException;


class PinsyncController extends ActiveController
{

    public $defaultAction = 'getCode';
    public $modelClass = 'app\models\PinPull';
    public $api_response    = ['status' => 0, 'msg' => 'Invalid Request', 'token' => '', 'data' => ''];

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['get-codes', 'sync-codes'],
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'sync-codes' => ['POST', 'OPTIONS'],
                    'get-codes' => ['GET'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    //all occasions list
    public function actionGetCodes()
    {
        try {

            $headers = Yii::$app->request->headers;
            $token = $headers->get('authorization');

            $eduId = \Yii::$app->api->validateAuthToken($token, 'get-codes');

            $update = PinPull::updateAll(['allocated_to' => 0], ['and', ['=', 'allocated_to', $eduId], ['=', 'is_used', 0]]);
            $pinCodes = PinPull::find()->where(['allocated_to' => 0, 'is_used' => 0])->limit(1000)->all();
            $codes = array_column($pinCodes, 'pin_number');
            $update = PinPull::updateAll(['allocated_to' => $eduId], ['and', ['in', 'pin_number', $codes]]);
            \Yii::$app->response->content = 'Data synced.';
            return $pinCodes;
        } catch (Exception $e) {
            Yii::$app->response->statusCode = $e->statusCode;
            return ['status' => 'error', 'code' => $e->statusCode, 'name' => $e->getMessage()];
        }
    }

    public function actionSyncCodes()
    {

        try {

            $headers = Yii::$app->request->headers;
            $token = $headers->get('authorization');
            $eduId = \Yii::$app->api->validateAuthToken($token, 'sync-codes');

            $body = json_decode(file_get_contents("php://input"), true);
            $data = \Yii::$app->api->jwtDecodeBody($body['data']);
            $usedCodes = $data['codes'];;
            $usedCodes = isset($usedCodes) ? $usedCodes : [];
            $update = PinPull::updateAll(['is_used' => 1], ['and', ['in', 'pin_number', $usedCodes], ['=', 'allocated_to', $eduId]]);
            $update = PinPull::updateAll(['allocated_to' => 0], ['and', ['=', 'allocated_to', $eduId], ['=', 'is_used', 0]]);
            \Yii::$app->response->content = 'Data synced.';
            return [];
        } catch (Exception $e) {
            Yii::$app->response->statusCode = $e->statusCode;
            return ['status' => 'error', 'code' => $e->statusCode, 'name' => $e->getMessage()];
        }
    }
}
