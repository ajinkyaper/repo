<?php

namespace app\modules\v1\controllers;

use Yii;
use app\models\Categories;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;

use Yii\base\Exception;

class CategoriesController extends ActiveController
{
    public $modelClass  = 'app\models\Categories';
    public $api_response    = ['status' => 0, 'msg' => 'Invalid Request', 'token' => '', 'data' => ''];

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['get-categories'],
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'get-categories' => ['GET'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    //all categories list
    public function actionGetCategories()
    {
        try {

            $headers = \Yii::$app->request->headers;
            $token = $headers->get('authorization');
            $eduId = \Yii::$app->api->validateAuthToken($token, 'get-categories');
            $find = ['status' => 1];
            Yii::$app->response->content = 'Data synced.';
            return Categories::find($find)->select(['id', 'category_name as name'])->asArray()->all();
        } catch (Exception $e) {
            Yii::$app->response->statusCode = $e->statusCode;
            return ['status' => 'error', 'code' => $e->statusCode, 'name' => $e->getMessage()];
        }
    }
}
