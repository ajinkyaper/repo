<?php

namespace app\modules\v1\controllers;

use Yii;
use app\models\Cocktail;
use app\models\Marques;
use Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;


class ProductsController extends ActiveController
{
    public $modelClass  = 'app\models\Cocktail';
    public $api_response    = ['status' => 0, 'msg' => 'Invalid Request', 'token' => '', 'data' => ''];

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['get-products'],
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'get-products' => ['GET'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    //all products list
    public function actionGetProducts()
    {
        try {
            $headers = Yii::$app->request->headers;
            $token = $headers->get('authorization');
            $eduId = \Yii::$app->api->validateAuthToken($token, 'get-products');
            //$body = json_decode(file_get_contents("php://input"), true);
            //$data = \Yii::$app->api->jwtDecodeBody($body['data']);

            $cocktails = Cocktail::find()
                ->with(['occasions', 'marques.brand' => function ($q) {
                    $q->where(['brand_details.status' => 1]);
                }])
                ->where(['is_active' => 1])
                ->andWhere(['!=', 'image', ""])
                ->all();

            $cocktailList = [];
            $i = 0;

            foreach ($cocktails as $index => $cocktail) {
                $imageUrl = Yii::$app->urlManager->createAbsoluteUrl('/', 'https') . 'uploads/cocktail/' . $cocktail->image;
                if (isset($cocktail->marques->brand->brand_name)) {
                    $cocktailList[$i] = [
                        'id' => $cocktail->id,
                        'name' => $cocktail->name,
                        'ingredients' => $cocktail->ingredients,
                        'instructions' => $cocktail->instructions,
                        'url' => $cocktail->url,
                        'brand_id' => $cocktail->marques->brand_id,
                        'brand_name' => $cocktail->marques->brand->brand_name,
                        'category_id' => $cocktail->marques->brand->category_id,
                        'image' => $imageUrl,
                        'occasions' => ArrayHelper::getColumn($cocktail->occasions, 'occasion_id'),
                    ];
                    $i++;
                }
            }

            $marques = Marques::find()
                //->alais('t')
                //->select([])
                ->with(['marquesOccasion', 'brand' => function ($q) {
                    $q->where(['brand_details.status' => 1]);
                }])
                ->where(['status' => 1])
                ->andWhere(['!=', 'image', ""])
                ->all();

            $marqueList = [];
            $i = 0;
            foreach ($marques as $index => $marque) {
                $imageUrl = Yii::$app->urlManager->createAbsoluteUrl('/', 'https') . 'uploads/marques/' . $marque->image;
                if (isset($marque->brand->brand_name)) {
                    $marqueList[$i] = [
                        'id' => $marque->id,
                        'name' => $marque->name,
                        'description' => $marque->description,
                        'price' => $marque->price,
                        'url' => $marque->url,
                        'brand_id' => $marque->brand_id,
                        'brand_name' => $marque->brand->brand_name,
                        'category_id' => $marque->brand->category_id,
                        'image' => $imageUrl,
                        'occasions' => ArrayHelper::getColumn($marque->marquesOccasion, 'occasion_id'),
                    ];
                    $i++;
                }
            }

            shuffle($cocktailList);
            shuffle($marqueList);
            \Yii::$app->response->content = 'Data synced.';
            return [
                'cocktails' => $cocktailList,
                'marques' => $marqueList
            ];
        } catch (Exception $e) {
            Yii::$app->response->statusCode = $e->statusCode;
            return ['status' => 'error', 'code' => $e->statusCode, 'name' => $e->getMessage()];
        }
    }
}
