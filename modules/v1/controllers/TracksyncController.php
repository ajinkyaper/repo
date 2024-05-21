<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\ProTrack;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\base\Exception;

class TracksyncController extends ActiveController
{

    public $defaultAction = 'sync';
    public $modelClass = 'app\models\ProTrack';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['sync'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [''],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'sync' => ['POST', 'OPTIONS'],
                ],
            ],
        ];
    }
    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }
    public function actionSync()
    {

        $rs = [

            'sync' => ''
        ];
        try {
            $headers = Yii::$app->request->headers;
            $token = $headers->get('authorization');
            $eid = \Yii::$app->api->validateAuthToken($token, 'tracksync');
            $body = json_decode(file_get_contents("php://input"), true);
            $data = \Yii::$app->api->jwtDecodeBody($body['data']);
            $connection = \Yii::$app->db;
            $stack = array();
            $successflag = false;
            $errorflag = false;
            $model = $this->modelClass;
            foreach ($data['data'] as $value) {
                $random_string = explode("_", $value['user_random_id']);
                //                    $added_on = date('Y-m-d H:i:s', strtotime($value['addedon']));
                $added_on = date("Y-m-d H:i:s", strtotime(substr($value['addedon'], 0, 19)));
                //                    echo 'date.timezone: ' . ini_get('date.timezone');
                //                    var_dump($added_on);
                //                    die;
                $session_start = strtotime($random_string[1]);
                $session_end = strtotime($added_on);
                $session_length = strtotime($value['addedon']) - strtotime($random_string[1]);

                $cocktailId = null;
                $marqueId = null;
                if ($value['type'] == 'cocktail') {
                    $cocktailId = $value['productid'];
                } elseif ($value['type'] == 'marque') {
                    $marqueId = $value['productid'];
                }

                $Trak = new ProTrack;
                $Trak->track_id = $value['trakid'];
                $Trak->pro_id = null;
                $Trak->cocktail_id = $cocktailId;
                $Trak->marque_id = $marqueId;
                $Trak->event_typ = $value['event'];
                $Trak->added_on = $added_on;
                $Trak->user_random_id = $value['user_random_id'];
                $Trak->edu_id = $eid;
                $Trak->mom_id = $value['momid'];
                $Trak->occ_id = $value['occid'];
                $Trak->brand_id = $value['brand'];
                $Trak->category = $value['category'];
                $Trak->session_length = date('H:i:s', $session_length);

                if (!$Trak->save()) {
                    $errorflag = true;
                } else {
                    $successflag = true;
                }
                // else {
                //     if ($value['event'] == 'occ_view_marques' || $value['event'] == 'occ_view_cocktails') {
                //         if ($value['event'] == 'occ_view_marques') {
                //             $product_type = 'marque';
                //             $products = $connection->createCommand("select m.id from marques m inner join marques_occasion mo on m.id=mo.marques_id where mo.occasion_id=:ocid group by m.id")->bindValue(':ocid', $value['occid']);
                //         } else {
                //             $product_type = 'cocktail';
                //             $products = $connection->createCommand("select c.id from cocktail c inner join cocktail_occasion co on c.id=co.cocktail_id where co.occasion_id=:ocid group by c.id")->bindValue(':ocid', $value['occid']);
                //         }

                //         $products = $products->queryAll();

                //         // $marque_products = $connection->createCommand("select p.pro_id from products p inner join pmo pm on p.pro_id=pm.pro_id where pm.occ_id=:ocid and p.pro_type=:pro_typ")
                //         //         ->bindValue(':ocid', $value['occid'])
                //         //         ->bindValue(':pro_typ', $product_type)
                //         //         ->queryAll();
                //         foreach ($products as $occ_mar_products) {
                //             $cocktailId = null;
                //             $marqueId = null;
                //             if ($product_type == 'cocktail') {
                //                 $cocktailId = $occ_mar_products['id'];
                //             } elseif ($product_type == 'marque') {
                //                 $marqueId = $occ_mar_products['id'];
                //             }

                //             $Trak_productview = new ProTrack;
                //             $Trak_productview->track_id = $value['trakid'];
                //             $Trak_productview->pro_id = null;
                //             $Trak_productview->cocktail_id = $cocktailId;
                //             $Trak_productview->marque_id = $marqueId;
                //             $Trak_productview->event_typ = 'product_view';
                //             $Trak_productview->added_on = $added_on;
                //             $Trak_productview->user_random_id = $value['user_random_id'];
                //             $Trak_productview->edu_id = $eid;
                //             $Trak_productview->mom_id = $value['momid'];
                //             $Trak_productview->occ_id = $value['occid'];
                //             $Trak_productview->brand_id = $value['brand'];
                //             $Trak_productview->category = $value['category'];
                //             $Trak_productview->session_length = date('H:i:s', $session_length);
                //             $Trak_productview->save();
                //         }
                //     }
                //     $successflag = true;
                //     array_push($stack, $value['trakid']);
                // }
            }
            Yii::$app->response->content = 'Data synced.';
            if ($successflag && $errorflag == false) {
                // $rs['status'] = 'success';
            } elseif ($successflag && $errorflag) {
                Yii::$app->response->content = 'success with error';
                return [];
                // $rs['status'] = 'success with error';
            } elseif ($successflag == false && $errorflag == true) {
                //$rs['status'] = 'error';
            }
            $rs['sync'] = $stack;

            return $rs;
        } catch (Exception $e) {
            Yii::$app->response->statusCode = $e->statusCode;
            return ['status' => 'error', 'code' => $e->statusCode, 'name' => $e->getMessage()];
        }
    }
}
