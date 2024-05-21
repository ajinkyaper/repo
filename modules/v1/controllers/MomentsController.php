<?php

namespace app\modules\v1\controllers;

use Yii;
use app\models\MomentV3;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\base\Exception;
use yii\db\Expression;

class MomentsController extends ActiveController
{
    public $modelClass  = 'app\models\MomentV3';
    public $api_response    = ['status' => 0, 'msg' => 'Invalid Request', 'token' => '', 'data' => ''];

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['get-moments'],
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'get-moments' => ['GET'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    //all moments list
    public function actionGetMoments()
    {

        try {
            $headers = \Yii::$app->request->headers;
            $token = $headers->get('authorization');
            $eduId = \Yii::$app->api->validateAuthToken($token, 'get-moments');
            Yii::$app->response->content = 'Data synced.';
            return MomentV3::find(['status' => 1])->select(['id', 'name', 'description',  new Expression("concat('" . Yii::$app->urlManager->createAbsoluteUrl('/uploads/moments/', 'https') . "','/',image) as image")])->andWhere(['!=', 'image', ""])->asArray()->all();
        } catch (Exception $e) {
            Yii::$app->response->statusCode = $e->statusCode;
            return ['status' => 'error', 'code' => $e->statusCode, 'name' => $e->getMessage()];
        }
    }
}
