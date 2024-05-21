<?php

namespace app\modules\v1\controllers;

use Yii;
use app\models\OccasionV3;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;

use yii\base\Exception;
use yii\db\Expression;

class OccasionsController extends ActiveController
{
    public $modelClass  = 'app\models\OccasionV3';
    public $api_response    = ['status' => 0, 'msg' => 'Invalid Request', 'token' => '', 'data' => ''];
    public $defaultAction = 'get-occasions';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['get-occasions'],
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'get-occasions' => ['GET']
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
    public function actionGetOccasions()
    {
        try {

            $headers = \Yii::$app->request->headers;
            $token = $headers->get('authorization');
            $eduId = \Yii::$app->api->validateAuthToken($token, 'get-occasions');
            // $body = json_decode(file_get_contents("php://input"), true);
            // $data = \Yii::$app->api->jwtDecodeBody($body['data']);
            // $moment_id = ($data['moment_id']) ? $data['moment_id'] : 0;
            $find = ['status' => 1];
            // if ($moment_id != 0) {
            //     $find['moment_id'] = $moment_id;
            // }
            Yii::$app->response->content = 'Data synced.';
            return OccasionV3::find($find)->select(['id', 'name', 'description', 'the_occasion as occasion', 'the_mood as mood', 'the_drink as drink', 'who', 'moment_id', new Expression("concat('" . Yii::$app->urlManager->createAbsoluteUrl('/uploads/occasions/', 'https') . "','/',image) as image")])->andWhere(['!=', 'image', ""])->asArray()->all();
        } catch (Exception $e) {
            Yii::$app->response->statusCode = $e->statusCode;
            return ['status' => 'error', 'code' => $e->statusCode, 'name' => $e->getMessage()];
        }
    }
}
