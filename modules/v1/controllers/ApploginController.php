<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\OtpVerification;
use app\models\Educators;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\db\Expression;

use yii\web\UnprocessableEntityHttpException;
use yii\web\NotFoundHttpException;
use yii\base\Exception;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;

class ApploginController extends ActiveController
{

    public $modelClass = 'app\models\ProTrack';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'verifyotp', 'check'],
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
                    'login' => ['POST'],
                    'verifyotp' => ['POST'],
                    'check' => ['GET', 'POST']
                ],
            ],
        ];
    }
    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }
    public function actionCheck()
    {
        try {
            $headers = \Yii::$app->request->headers;
            $token = $headers->get('authorization');
            $eduId = \Yii::$app->api->validateAuthToken($token, 'get-codes');

            $body = json_decode(file_get_contents("php://input"), true);

            $data = \Yii::$app->api->jwtDecodeBody($body['data']);

            return ['header' => $eduId, 'data' => $data];
        } catch (Exception $e) {

            Yii::$app->response->statusCode = $e->statusCode;
            return ['status' => 'error', 'code' => $e->statusCode, 'name' => $e->getMessage()];
        }
    }
    public function actionLogin()
    {
        try {
            $headers = \Yii::$app->request->headers;
            $token = $headers->get('authorization');
            $eduId = \Yii::$app->api->validateAuthToken($token, 'login'); // return 0

            $body = json_decode(file_get_contents("php://input"), true);
            $data = \Yii::$app->api->jwtDecodeBody($body['data']);
            $email = isset($data['email']) ? $data['email'] : '';

            $modelUser = new Educators();
            $modelUser->scenario = 'api';
            $modelUser->email = $email;
            $valid = $modelUser->validate();
            if (!$valid) {

                Yii::$app->response->content = Yii::$app->api->getErrorsList($modelUser);
                return [];
                //return Yii::$app->api->getErrorsList($modelUser);

            }

            $user_model = $modelUser::find()->where(['email' => $email, 'status' => 1])->one();

            // if (!$user_model) {
            //     throw new NotFoundHttpException("User not found.");
            // }
            // $email = $user_model->email;
            // if (!$email) {
            //     throw new NotFoundHttpException("No email address registered with your account");
            // }
            // Otp 5 minutes validation
            $Recent_otp_verification = OtpVerification::find()->where(['edu_id' => $user_model->edu_id])
                ->andWhere(['>', new Expression('DATE_ADD(generated_time,INTERVAL 5 MINUTE)'), new Expression('NOW()')])
                ->orderBy(['id' => SORT_DESC])
                ->one();

            if (!empty($Recent_otp_verification)) {
                throw new UnprocessableEntityHttpException(\yii::$app->api->api_errors('FH-MAX-ATTEMPT'));
            }

            $six_digit_random_number = mt_rand(100000, 999999);
            $Otp_verification = OtpVerification::find()->where(['edu_id' => $user_model->edu_id])->one();
            if ($Otp_verification) {
                $Old_otp_verification = OtpVerification::find()->where(['edu_id' => $user_model->edu_id])
                    ->andWhere(['>', new Expression('DATE_ADD(generated_time,INTERVAL 1 DAY)'), new Expression('NOW()')])
                    ->orderBy(['id' => SORT_DESC])
                    ->one();
                if (!empty($Old_otp_verification)) {
                    $Otp_verification->otp = $Old_otp_verification->otp;
                    $six_digit_random_number = $Old_otp_verification->otp;
                } else {
                    $Otp_verification->otp = $six_digit_random_number;
                }
                $Otp_verification->generated_time = new Expression('NOW()');
                $status = $Otp_verification->save();
            } else {

                $otp = new OtpVerification();
                $otp->edu_id = $user_model->edu_id;
                $otp->generated_time = new Expression('NOW()');
                $otp->otp = $six_digit_random_number;
                $status = $otp->save();
            }

            if ($status) {

                // below code prevent from mutiple device login for single user
                // $user_model->auth_key = \Yii::$app->security->generateRandomString();
                // $user_model->access_token = \Yii::$app->security->generateRandomString();
                // $user_model->save();

                $is_mailsend = \Yii::$app->mailer->compose(['html' => 'otp-html'], ['otp' => $six_digit_random_number])
                    ->setFrom([\Yii::$app->params['smtpFrom'] => 'DIAGEO'])
                    ->setTo($email)
                    ->setSubject('Discover A Drink : DIAGEO')
                    ->send();
                if ($is_mailsend) {
                    \Yii::$app->response->content = 'Mail otp send successfully';
                    $rs['edu_name'] = $user_model->edu_name;
                    $rs['edu_id'] = $user_model->edu_id;
                    //$rs['token'] = $user_model->access_token;
                    return $rs;
                } else {
                    Yii::$app->response->content = Yii::$app->api->api_errors('FH-UNEXPECTED');
                    return [];
                }
            }
            \Yii::$app->response->content = 'Mail otp send successfully';
            $rs['edu_name'] = $user_model->edu_name;
            $rs['edu_id'] = $user_model->edu_id;
            //$rs['token'] = $user_model->access_token;
            return $rs;
        } catch (Exception $e) {
            Yii::$app->response->statusCode = $e->statusCode;
            return ['status' => 'error', 'code' => $e->statusCode, 'name' => $e->getMessage()];
        }
    }

    public function actionVerifyotp()
    {
        try {

            $headers = \Yii::$app->request->headers;
            $token = $headers->get('authorization');

            $eduId = \Yii::$app->api->validateAuthToken($token, 'verifyotp');

            $body = json_decode(file_get_contents("php://input"), true);
            $data = \Yii::$app->api->jwtDecodeBody($body['data']);
            $email = isset($data['email']) ? $data['email'] : '';
            $otp = isset($data['otp']) ? $data['otp'] : '';


            $modelOtpVerification = new OtpVerification();
            $modelOtpVerification->scenario = 'api';
            $modelOtpVerification->email = $email;
            $modelOtpVerification->otp = $otp;
            $valid = $modelOtpVerification->validate();

            if (!$valid) {
                Yii::$app->response->content = Yii::$app->api->getErrorsList($modelOtpVerification);
                return [];
            }

            $educator = Educators::find()->where(['email' => $modelOtpVerification->email])->one();

            if (empty($educator)) {
                Yii::$app->response->content = 'Educator not found.';
                return [];
            }

            $Otp_verification = OtpVerification::find()->where(['edu_id' => $educator->edu_id, 'otp' => $otp])
                ->andWhere(['>', new Expression('DATE_ADD(generated_time,INTERVAL 1 DAY)'), new Expression('NOW()')])
                ->one();

            if (!$Otp_verification) {
                \Yii::$app->response->content = 'Invalid OTP.';
                return [];
            }

            // delete otp after successfully verified 
            \Yii::$app->response->content = 'OTP Verified';
            if ($educator->access_token == "") {
                $educator->auth_key = \Yii::$app->security->generateRandomString();
                $educator->access_token = \Yii::$app->security->generateRandomString();
                $educator->save();
            }
            $Otp_verification->delete();
            return ['token' => $educator->access_token];
        } catch (Exception $e) {
            Yii::$app->response->statusCode = $e->statusCode;
            return ['status' => 'error', 'code' => $e->statusCode, 'name' => $e->getMessage()];
        }
    }
}
