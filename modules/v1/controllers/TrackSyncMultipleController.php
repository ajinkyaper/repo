<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;
use app\models\ProTrackNew;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
class TrackSyncMultipleController extends \yii\web\Controller
{
    public $modelClass = 'app\models\ProTrackNew';

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [''],
                        'roles' => ['@'],
                    ],
                ],
            ],
            // 'verbs' => [
            //     'class' => VerbFilter::className(),
            //     'actions' => [
            //         'index' => ['POST', 'OPTIONS','GET'],
            //     ],
            // ],
        ];
    }
    public function actionIndex()
    {
        $connection = \Yii::$app->db;
        $stack = array();
        $successflag = false;
        $errorflag = false;
        $rs = [
            'status' => '',
            'sync' => $stack
        ];
        try {

            $model = $this->modelClass;
            $data = json_decode(file_get_contents("php://input"), true);
            //$post = \Yii::$app->api->get_log($data);
            // retrieve row data
            $token = isset($data['token']) ? $data['token'] : '';
             $validate_token = \Yii::$app->api->validate_token($token, true); // valiadate token send by the device
             if ($validate_token->valid) {
             
                $token_res = explode('-', $token);
                $eid = $token_res[4];

                foreach ($data['data'] as $value) {
                    return $value;
                    exit;
                    $random_string = explode("_", $value['user_random_id']);

                    $added_on = date("Y-m-d H:i:s", strtotime(substr($value['addedon'], 0, 19)));

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

                    $Trak = new ProTrackNew;
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
                        if ($value['event'] == 'occ_view_marques' || $value['event'] == 'occ_view_cocktails') {
                            if ($value['event'] == 'occ_view_marques') {
                                $product_type = 'marque';
                                $products = $connection->createCommand("select m.id from marques m inner join marques_occasion mo on m.id=mo.marques_id where mo.occasion_id=:ocid group by m.id")->bindValue(':ocid', $value['occid']);
                            } else {
                                $product_type = 'cocktail';
                                $products = $connection->createCommand("select c.id from cocktail c inner join cocktail_occasion co on c.id=co.cocktail_id where co.occasion_id=:ocid group by c.id")->bindValue(':ocid', $value['occid']);
                            }

                            $products = $products->queryAll();

           
                            foreach ($products as $occ_mar_products) {
                                $cocktailId = null;
                                $marqueId = null;
                                if ($product_type == 'cocktail') {
                                    $cocktailId = $occ_mar_products['id'];
                                } elseif ($product_type == 'marque') {
                                    $marqueId = $occ_mar_products['id'];
                                }

                                $Trak_productview = new ProTrackNew;
                                $Trak_productview->track_id = $value['trakid'];
                                $Trak_productview->pro_id = null;
                                $Trak_productview->cocktail_id = $cocktailId;
                                $Trak_productview->marque_id = $marqueId;
                                $Trak_productview->event_typ = 'product_view';
                                $Trak_productview->added_on = $added_on;
                                $Trak_productview->user_random_id = $value['user_random_id'];
                                $Trak_productview->edu_id = $eid;
                                $Trak_productview->mom_id = $value['momid'];
                                $Trak_productview->occ_id = $value['occid'];
                                $Trak_productview->brand_id = $value['brand'];
                                $Trak_productview->category = $value['category'];
                                $Trak_productview->session_length = date('H:i:s', $session_length);
                                $Trak_productview->save();
                            }
                        }
                        $successflag = true;
                        array_push($stack, $value['trakid']);
                    }
                }
                if ($successflag && $errorflag == false) {
                    $rs['status'] = 'success';
                } elseif ($successflag && $errorflag) {
                    $rs['status'] = 'success with error';
                } elseif ($successflag == false && $errorflag == true) {
                    $rs['status'] = 'error';
                }
                $rs['sync'] = $stack;
                echo \Yii::$app->api->flush_response($rs);
                exit();
            }
        } catch (\yii\base\Exception $exc) {
            $rs['status'] = \yii::$app->api->api_errors('FH-UNEXPECTED');
            echo \Yii::$app->api->flush_response($rs);
            exit();
        }
    }
public function p($o, $exit = false, $dump = false)
    {
        echo '<pre>';
        if ($dump) var_dump($o); else print_r($o);
        echo '</pre>';
        if ($exit || true) exit;
    }
}
