<?php

namespace app\modules\v1\controllers;

use Yii;
use app\models\Educators;
use app\models\Products;
use app\models\Cocktail;
use app\models\Marques;
use app\models\EduPiiCount;
use app\models\TrailSubmissions;
use app\models\SubmissionProducts;
use app\models\SubmissionProductV3;
use app\models\SpeedRails;
use app\models\SpeedrailProducts;
use app\models\PinPull;
use yii\rest\ActiveController;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\base\Exception;

class ApiController extends ActiveController
{

    public $modelClass = 'app\models\TrailSubmissions';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['sendmail', 'save-speedrail'],
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
                    'sendmail' => ['POST'],
                    'save-speedrail' => ['POST'],
                ],
            ],
        ];
    }
    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }
    // track user session start time and end time here
    public function actionSendmail()
    {
        try {
            $connection = \Yii::$app->db->beginTransaction();
            $headers = Yii::$app->request->headers;
            $token = $headers->get('authorization');
            $eid = \Yii::$app->api->validateAuthToken($token, 'sendmail');
            $request_type = "";
            $body = json_decode(file_get_contents("php://input"), true);
            $data = ['data' => []];
            $pii_Count = 0;
            $arr = [];
            if ($body and isset($body['data'])) {
                $data = \Yii::$app->api->jwtDecodeBody($body['data']);
            };
            foreach ($data['data'] as $value) { //loop of orders

                $email = $value['email'];
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    // valid address
                } else {
                    $email = \Yii::$app->api->aes_decrypt($value['email']);
                }

                $user_random_id = $value['urid'];
                $sub_id = $value['subid'];


                $request_type = $value['request_type'];
                $dateval = str_replace("T", " ", $value['subdate']);
                $sub_date = date("Y-m-d H:i:s", strtotime(substr($dateval, 0, 19)));
                $data['data'][0]['email_decrypted'] = $email;
                // $dob = $value['dob'];
                // if (!strtotime($value['dob'])) {
                //     $dob = \Yii::$app->api->aes_decrypt($value['dob']);
                // }
                // $data['data'][0]['dob_decrypted'] = $dob;
                // return $data;
                // exit;
                $TrailSubmissions = new TrailSubmissions;
                $TrailSubmissions->sub_date = $sub_date;
                $TrailSubmissions->edu_id = $eid;
                $TrailSubmissions->user_random_id = $user_random_id;
                $TrailSubmissions->req_time = date(\Yii::$app->params['dateformat']);
                $TrailSubmissions->sub_id = $sub_id;
                $TrailSubmissions->request_type = $request_type;

                $arr = [];
                if ($TrailSubmissions->save()) {
                    if ($request_type == 'submit') {
                        $pii_Count++;
                    }
                    $order_no = 1;
                    if (is_array($value['product'])) {
                        $products = $value['product'];
                    } else {
                        $pro_string = str_replace(array('[', ']'), '', $value['product']);
                        $products = explode(",", $pro_string);
                    }



                    foreach ($products as $key => $product) {
                        $arrToPush = [
                            'type' => $product['type']
                        ];

                        $datas = [];
                        $cocktailId = null;
                        $marqueId = null;
                        if ($product['type'] == 'cocktail') {
                            $cocktailId = $product['id'];
                            $datas = Cocktail::find()->with('marques.brand.category')->where(['id' => $product['id']])->one();
                        } elseif ($product['type'] == 'marque') {
                            $marqueId = $product['id'];
                            $datas = Marques::find()->with('brand.category')->where(['id' => $product['id']])->one();
                        }

                        $arrToPush['data'] = $datas;
                        array_push($arr, $arrToPush);

                        $subProd = new SubmissionProducts;
                        $subProd->req_id = $TrailSubmissions->id;
                        $subProd->cocktail_id = $cocktailId;
                        $subProd->marque_id = $marqueId;
                        $subProd->order_no = $order_no;
                        $subProd->sub_date = $sub_date;
                        $subProd->save();
                        $order_no++;
                    }
                }
            }
            if ($request_type == 'submit') {
                if ($pii_Count != 0) {
                    $EduPiiCount = new EduPiiCount;
                    $EduPiiCount->req_time = $sub_date;
                    $EduPiiCount->edu_id = $eid;
                    $EduPiiCount->req_count = $pii_Count;
                    $EduPiiCount->save();
                }
                if (count($arr) > 0) { // send mail when the request type is submit 
                    $logo = \Yii::$app->urlManager->createAbsoluteUrl('/', 'https') . 'img/' . 'top-logo-with-img.png';
                    $is_mailsend = \Yii::$app->mailer->compose(['html' => 'mail-recommendation-html'], ['data' => $arr, 'user_random_id' => $user_random_id, 'edu_id' => $eid, 'logo' => $logo])
                        ->setFrom([\Yii::$app->params['smtpFrom'] => 'DIAGEO'])
                        ->setTo($email)
                        ->setSubject('Discover A Drink : DIAGEO')
                        ->send();
                    if (!$is_mailsend) {
                        throw new Exception("Sorry! please try again.");
                    }
                }
            }
            Yii::$app->response->content = 'Data synced.';
            $connection->commit();
            return [];
        } catch (Exception $e) {
            $connection->rollBack();
            Yii::$app->response->statusCode = $e->statusCode;
            return ['status' => 'error', 'code' => $e->statusCode, 'name' => $e->getMessage()];
        }
    }

    public function actionSaveSpeedrail()
    {
        try {
            $connection = \Yii::$app->db->beginTransaction();
            $headers = Yii::$app->request->headers;
            $token = $headers->get('authorization');
            $eid = \Yii::$app->api->validateAuthToken($token, 'save-speedrail');
            $request_type = "";
            $body = json_decode(file_get_contents("php://input"), true);
            $data = ['data' => []];
            if ($body and isset($body['data'])) {
                $data = \Yii::$app->api->jwtDecodeBody($body['data']);
            }
            $isrecordExist = false;

            $pii_Count = 0;
            $oldPin = isset($data['data'][0]['pin']) ? $data['data'][0]['pin'] : '';
            $oldUrId = isset($data['data'][0]['urid']) ? $data['data'][0]['urid'] : '';
            if (!empty($oldUrId)) {
                $TrailSubmissionsRecord = TrailSubmissions::find()->where(['user_random_id' => $oldUrId])->count();
                $speedrailRecord = SpeedRails::find()->where(['pin' => $oldPin])->count();
                $isrecordExist = $TrailSubmissionsRecord > 0 ? true : false;
            }
            foreach ($data['data'] as $value) { //loop of orders


                $user_random_id = $value['urid'];
                //$sub_id = $value['subid'];
                $request_type = $value['request_type'];
                $dateval = str_replace("T", " ", $value['subdate']);
                $sub_date = date("Y-m-d H:i:s", strtotime(substr($dateval, 0, 19)));


                if (!$isrecordExist) {
                    $TrailSubmissions = new TrailSubmissions;
                    $TrailSubmissions->sub_date = $sub_date;
                    $TrailSubmissions->edu_id = $eid;
                    $TrailSubmissions->user_random_id = $user_random_id;
                    $TrailSubmissions->req_time = date(\Yii::$app->params['dateformat']);
                    //$TrailSubmissions->sub_id = $sub_id;
                    $TrailSubmissions->request_type = $request_type;
                    $TrailSubmissions->is_pin = 1;
                    $var = $TrailSubmissions->save();


                    if ($TrailSubmissions->save()) {
                        if ($request_type == 'submit') {
                            $pii_Count++;
                        }
                        $order_no = 1;

                        if (is_array($value['product'])) {
                            $products = $value['product'];
                        } else {
                            $pro_string = str_replace(array('[', ']'), '', $value['product']);
                            $products = explode(",", $pro_string);
                        }

                        $speedRails = new SpeedRails;
                        $speedRails->edu_id = $eid;
                        $speedRails->pin = $value['pin'];
                        $speedRails->trail_submission_id = $TrailSubmissions->id;
                        $speedRails->save();
                        $pinCodes = PinPull::find()->where(['pin_number' => $value['pin']])->one();
                        $pinCodes->is_used = 1;
                        $pinCodes->save();
                        foreach ($products as $key => $product) {
                            $speedrailProducts = new SpeedrailProducts;
                            $speedrailProducts->speedrail_id = $speedRails->id;
                            $speedrailProducts->product_id = $product['id'];
                            $speedrailProducts->type = $product['type'];

                            $speedrailProducts->save();

                            $cocktailId = null;
                            $marqueId = null;
                            if ($product['type'] == 'cocktail') {
                                $cocktailId = $product['id'];
                            } elseif ($product['type'] == 'marque') {
                                $marqueId = $product['id'];
                            }

                            $subProd = new SubmissionProducts;
                            $subProd->req_id = $TrailSubmissions->id;
                            $subProd->cocktail_id = $cocktailId;
                            $subProd->marque_id = $marqueId;
                            $subProd->order_no = $order_no;
                            $subProd->sub_date = $sub_date;
                            $subProd->save();
                            $order_no++;
                        }
                    }
                } else {
                    if ($request_type == 'submit') {
                        $pii_Count++;
                    }
                    $order_no = 1;

                    if (is_array($value['product'])) {
                        $products = $value['product'];
                    } else {
                        $pro_string = str_replace(array('[', ']'), '', $value['product']);
                        $products = explode(",", $pro_string);
                    }


                    $oldTrail = TrailSubmissions::find()->where(['user_random_id' => $oldUrId])->one();
                    $speedrailOld = SpeedRails::find()->where(['trail_submission_id' => $oldTrail->id])->one();
                    $oldPin = $speedrailOld->pin;
                    $trail_submission_id = $oldTrail->id;

                    $oldPinData = PinPull::find()->where(['pin_number' => $oldPin])->one();
                    $oldPinData->is_used = 0;
                    $oldPinData->save();

                    Speedrails::deleteAll(['trail_submission_id' => $oldTrail->id]);
                    SpeedrailProducts::deleteAll(['speedrail_id' => $speedrailOld->id]);
                    SubmissionProducts::deleteAll(['req_id' => $trail_submission_id]);


                    $speedRails = new SpeedRails;
                    $speedRails->edu_id = $eid;
                    $speedRails->pin = $value['pin'];
                    $speedRails->trail_submission_id = $trail_submission_id;
                    $speedRails->save();
                    $pinCodes = PinPull::find()->where(['pin_number' => $value['pin']])->one();
                    $pinCodes->is_used = 1;
                    $pinCodes->save();

                    foreach ($products as $key => $product) {
                        $speedrailProducts = new SpeedrailProducts;
                        $speedrailProducts->speedrail_id = $speedRails->id;
                        $speedrailProducts->product_id = $product['id'];
                        $speedrailProducts->type = $product['type'];

                        $speedrailProducts->save();

                        $cocktailId = null;
                        $marqueId = null;
                        if ($product['type'] == 'cocktail') {
                            $cocktailId = $product['id'];
                        } elseif ($product['type'] == 'marque') {
                            $marqueId = $product['id'];
                        }

                        $subProd = new SubmissionProducts;
                        $subProd->req_id = $trail_submission_id;
                        $subProd->cocktail_id = $cocktailId;
                        $subProd->marque_id = $marqueId;
                        $subProd->order_no = $order_no;
                        $subProd->sub_date = $sub_date;
                        $subProd->save();
                        $order_no++;
                    }
                }
            }
            if ($request_type == 'submit' && !$isrecordExist) {
                if ($pii_Count != 0) {
                    $EduPiiCount = new EduPiiCount;
                    $EduPiiCount->req_time = $sub_date;
                    $EduPiiCount->edu_id = $eid;
                    $EduPiiCount->req_count = $pii_Count;
                    $EduPiiCount->save();
                }
            }
            Yii::$app->response->content = 'Data synced.';
            $connection->commit();
            return [];
        } catch (Exception $e) {
            $connection->rollBack();
            Yii::$app->response->statusCode = $e->statusCode;
            return ['status' => 'error', 'code' => $e->statusCode, 'name' => $e->getMessage()];
        }
    }
}
