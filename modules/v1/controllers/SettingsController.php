<?php

namespace app\modules\v1\controllers;

use Yii;
use app\models\UserSync;
use app\models\LoginScreen;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\rest\ActiveController;

use yii\base\Exception;
use yii\web\UnauthorizedHttpException;

class SettingsController extends ActiveController
{
    public $modelClass  = 'app\models\LoginScreen';
    public $api_response    = ['status' => 0, 'message' => 'Invalid Request',  'data' => '', 'code' => 200];

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['get-login-screen', 'check-updates', 'test', 'generate-jwt-data'],
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'get-login-screen' => ['GET'],
                    'check-updates' => ['GET'],
                    'test' => ['GET', 'POST'],
                ],
            ],


        ];
    }

    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return parent::beforeAction($action);
    }

    public function actionGetLoginScreen()
    {
        try {
            $headers = Yii::$app->request->headers;
            $token = $headers->get('authorization');

            $eduId = \Yii::$app->api->validateAuthToken($token, 'get-login-screen'); // return 0

            $loginScreen = LoginScreen::find()->one();
            \Yii::$app->response->content = 'Login screen retrieved.';
            return  [
                'url' =>
                Yii::$app->urlManager->createAbsoluteUrl('/', 'https') . 'uploads/login_screen/' . $loginScreen->image
            ];
        } catch (Exception $e) {
            Yii::$app->response->statusCode = $e->statusCode;
            return ['status' => 'error', 'code' => $e->statusCode, 'name' => $e->getMessage()];
        }
    }


    public function actionCheckUpdates()
    {
        try {
            $headers = Yii::$app->request->headers;
            $token = $headers->get('authorization');

            $eduId = \Yii::$app->api->validateAuthToken($token, 'check-updates');

            $updateSync = UserSync::find()->one();
            \Yii::$app->response->content = 'Data synced.';
            return ['last_updated_at' => $updateSync->updated_at];
        } catch (Exception $e) {
            Yii::$app->response->statusCode = $e->statusCode;
            return ['status' => 'error', 'code' => $e->statusCode, 'name' => $e->getMessage()];
        }
    }



    public function actionTest()
    {
        try {

            $data = json_decode(file_get_contents("php://input"), true);
            $token = ['request' => $data['request'], 'access-token' => '0g9Ak-dVW2nfNHm5f8Cpje2I6_S0yQPj', 'expiry' => date('Y-m-d H:i:s')];
            $token = \Yii::$app->api->jwtEncode($token);
            echo $token;
            exit;
        } catch (Exception $e) {
            Yii::$app->response->statusCode = $e->statusCode;
            return ['status' => 'error', 'code' => $e->statusCode, 'message' => $e->getMessage()];
        }
    }
    public function actionGenerateJwtData()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $token = ['exp' => time() + 300000, 'otp' => $data['otp']];
        $token = \Yii::$app->api->jwtEncode($token);
        echo $token;
        exit;
    }
}
