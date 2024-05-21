<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\db\Expression;
use app\models\Marques;
use app\models\PinPull;
use app\models\Cocktail;
use app\models\MomentV3;
use app\models\Categories;
use app\models\OccasionV3;
use yii\filters\VerbFilter;
use app\models\BrandDetails;
use yii\helpers\ArrayHelper;
use app\models\CocktailSearch;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use app\models\EducatorActivityTrack;

use yii\base\Exception;
use yii\web\UnprocessableEntityHttpException;

class ActivitysyncController extends ActiveController
{

    public $defaultAction = 'getCode';
    public $modelClass = 'app\models\PinPull';
    public $api_response    = ['status' => 0, 'msg' => 'Invalid Request', 'data' => []];

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update-activity', 'get-updated-data'],
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'send-otp' => ['POST'],
                    'get-updated-data' => ['POST', 'OPTIONS'],
                    'update-activity' => ['POST'],
                ],
            ],
        ];
    }
    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    public function actionUpdateActivity()
    {

        try {
            $headers = Yii::$app->request->headers;
            $token = $headers->get('authorization');

            $eduId = \Yii::$app->api->validateAuthToken($token, 'update-activity');

            $body = json_decode(file_get_contents("php://input"), true);
            $data = \Yii::$app->api->jwtDecodeBody($body['data']);

            $login_data = isset($data['login']) ? $data['login'] : '';
            $logout_data = isset($data['logout']) ? $data['logout'] : '';
            $device_id =  @$data['device_id'];
            $edu_id = @$data['edu_id'];

            if (!$edu_id) {
                \Yii::$app->response->content = 'Educator not found.';
                return [];
            }

            if (!$device_id) {
                \Yii::$app->response->content = 'Device not found.';
                return [];
            }

            $login_activity = new EducatorActivityTrack();
            $logout_activity = new EducatorActivityTrack();
            if (!empty($login_data)) {
                //$login_activity->market = $market;
                $login_activity->device_id = $device_id;
                $login_activity->edu_id = $edu_id;
                $login_activity->timestamp = $login_data['timestamp'];
                $login_activity->pin_downloaded = isset($login_data['pin_downloaded']) ? $login_data['pin_downloaded'] : 0;
                $login_activity->pin_returned = isset($login_data['pin_returned']) ? $login_data['pin_returned'] : 0;
                $login_activity->activity = 'login';
                $login_activity->save();
            }
            if (!empty($logout_data)) {
                //$logout_activity->market = $market;
                $logout_activity->device_id = $device_id;
                $logout_activity->edu_id = $edu_id;
                $logout_activity->timestamp = $logout_data['timestamp'];
                $logout_activity->pin_downloaded = isset($logout_data['pin_downloaded']) ? $logout_data['pin_downloaded'] : 0;
                $logout_activity->pin_returned = isset($logout_data['pin_returned']) ? $logout_data['pin_returned'] : 0;
                $logout_activity->activity = 'logout';
                $logout_activity->save();
            }
            \Yii::$app->response->content = 'Data updated.';
            return [];
        } catch (Exception $e) {
            Yii::$app->response->statusCode = $e->statusCode;
            return ['status' => 'error', 'code' => $e->statusCode, 'name' => $e->getMessage()];
        }
    }

    public function actionGetUpdatedData()
    {

        try {
            $headers = Yii::$app->request->headers;
            $token = $headers->get('authorization');

            $eduId = \Yii::$app->api->validateAuthToken($token, 'get-updated-data');

            $body = json_decode(file_get_contents("php://input"), true);
            $data = \Yii::$app->api->jwtDecodeBody($body['data']);
            $last_date = @$data['last_sync_date'];

            if (!Yii::$app->api->is_valid_date($last_date)) {
                \Yii::$app->response->content = 'Invalid Date.';
                return [];
                //throw new UnprocessableEntityHttpException("Invalid Date Input."); // need to discuss
            }

            //$lastSyncDate = $data['last_sync_date']; // not use any where

            $brands_data = BrandDetails::find()->select(["id", "brand_name AS name", "category_id", "status"])
                //->where(['status'=>1])
                ->where(['>=', 'updated_at', $last_date])
                ->orderBy(['updated_at' => SORT_DESC])
                ->asArray()
                ->all();
            $responseData['brands'] = $brands_data;

            $categories_data = Categories::find()->select(["id", "category_name AS name", "status"])
                //->where(['status'=>1])
                ->where(['>=', 'updated_at', $last_date])
                ->orderBy(['updated_at' => SORT_DESC])
                ->asArray()
                ->all();

            $responseData['categories'] = $categories_data;

            $path   = Yii::$app->urlManager->createAbsoluteUrl('/', 'https') . 'uploads/moments/';
            $moments_data = MomentV3::find()
                ->select(["id", "name", "description", new Expression('CONCAT("' . $path . '",image) AS image')])
                //->where(['status'=>1])
                ->where(['>=', 'updated_at', $last_date])
                ->andWhere(['!=', 'image', ""])
                ->orderBy(['updated_at' => SORT_DESC])
                ->asArray()->all();
            $responseData['moments'] = $moments_data;

            $path   = Yii::$app->urlManager->createAbsoluteUrl('/', 'https') . 'uploads/occasions/';
            $occasion_data = OccasionV3::find()->select(["id", "name", "description", "moment_id", "the_occasion AS occasion", "the_mood AS mood", "the_drink AS drink", "who", new Expression('CONCAT("' . $path . '",image) AS image')])
                //->where(['status'=>1])
                ->where(['>=', 'updated_at', $last_date])
                ->orderBy(['updated_at' => SORT_DESC])
                ->andWhere(['!=', 'image', ""])
                ->asArray()->all();
            $responseData['occasion'] = $occasion_data;


            $cocktails = Cocktail::find()
                ->with('occasions', 'marques.brand')
                //->where(['is_active' => 1])
                ->where(['>=', 'updated_at', $last_date])
                ->andWhere(['!=', 'image', ""])
                ->orderBy(['updated_at' => SORT_ASC, 'name' => 'SORT_DESC'])
                ->all();

            $searchModel = new CocktailSearch();
            $dataProvider = $searchModel->updatedData($last_date);

            //var_dump($dataProvider->getModels());die();

            $cocktailList = [];
            $i = 0;
            foreach ($dataProvider->getModels() as $index => $cocktail) {
                $imageUrl = Yii::$app->urlManager->createAbsoluteUrl('/', 'https') . 'uploads/cocktail/' . $cocktail->image;
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
                    'status' => $cocktail->is_active,
                    'updated_at' => $cocktail->updated_at
                ];
                $i++;
            }

            // $cocktailList = [];
            // $i = 0;
            // foreach ($cocktails as $index => $cocktail) {
            //     $imageUrl = Yii::$app->urlManager->createAbsoluteUrl('/').'uploads/cocktail/'.$cocktail->image;
            //     $cocktailList[$i] = [
            //         'id' => $cocktail->id,
            //         'name' => $cocktail->name,
            //         'ingredients' => $cocktail->ingredients,
            //         'instructions' => $cocktail->instructions,
            //         'url' => $cocktail->url,
            //         'brand_id' => $cocktail->marques->brand_id,
            //         'brand_name' => $cocktail->marques->brand->brand_name,
            //         'category_id' => $cocktail->marques->brand->category_id,
            //         'image' => $imageUrl,
            //         'occasions' => ArrayHelper::getColumn($cocktail->occasions,'occasion_id'),
            //         'status' => $cocktail->is_active,
            //         'updated_at' => $cocktail->updated_at
            //     ];
            //     $i++;
            // }

            $marques = Marques::find()
                ->with('marquesOccasion', 'brand')
                //->where(['status' => 1])
                ->andWhere(['>=', 'updated_at', $last_date])
                ->andWhere(['!=', 'image', ""])
                ->orderBy(['updated_at' => SORT_DESC])
                ->all();

            $marqueList = [];
            $i = 0;
            foreach ($marques as $index => $marque) {
                $imageUrl = Yii::$app->urlManager->createAbsoluteUrl('/', 'https') . 'uploads/marques/' . $marque->image;
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
                    'status' => $marque->status
                ];
                $i++;
            }
            $responseData['cocktail'] = $cocktailList;
            $responseData['marques'] = $marqueList;
            \Yii::$app->response->content = 'Data synced.';
            return $responseData;
        } catch (Exception $e) {
            Yii::$app->response->statusCode = $e->statusCode;
            return ['status' => 'error', 'code' => $e->statusCode, 'name' => $e->getMessage()];
        }
    }
}
