<?php

namespace app\components;

use Yii;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use yii\base\Component;
use app\models\Educators;

use common\models\AccessKey;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\SignatureInvalidException;
use yii\web\UnauthorizedHttpException;

class Api extends Component
{

    private $min_version = '1.1.0';
    protected static $aes_key = "3DF24C98D6372EB0E6979663794795C0701D2D06A92FEB642F2C9DFE3C4E60B5";
    protected static $aes_iv = "abcdef9876543210abcdef9876543210";
    public static $push_debug = false;
    public static $response_enc = false;
    public static $request_hash_dec = true;
    public static $key_token_dec = true;
    public static $max_repeat_request = 7;
    public static $check_max_repeat_request = false;
    public static $user_agent_match = false;

    //jwt auth token params
    public static $jwtKey  = "Discover!@#2022";
    public static $jwtAlgo  = "HS256";
    public static $jwtExp  = 300000;





    public static function flush_response($rs)
    {
        $resp = json_encode($rs);
        return $resp;
    }

    public static function prepare_response($status = 'error', $code = 500, $message = '', $data = [])
    {
        $response['status'] = $status;
        $response['code'] = (int)$code;
        $response['message'] = $message;
        if ($data) {
            $response['data'] = $data;
        }

        return \Yii::createObject([
            'class' => 'yii\web\Response',
            'format' => \yii\web\Response::FORMAT_JSON,
            'statusCode' => $response['code'],
            'data' => ['data' => $response],
        ]);
    }

    public function RandomString($str)
    {
        $length = 6;
        $randomString = substr(str_shuffle($str), 0, $length);
        return $randomString;
    }

    public function api_errors($code)
    {
        $error = '';
        switch ($code) {
            case 'FH-GENERIC';
                $error = "Please check your internet connection.";
                break;
            case 'FH-UNEXPECTED';
                $error = "Sorry, an unexpected error has occurred.";
                break;
            case 'FH-INVALID';
                $error = "Invalid Request or We are unable to load the data.";
                break;
            case 'FH-SESSION';
                $error = "Invalid session. Please try again.";
                break;
            case 'FH-TOKEN';
                $error = "Invalid token. Please try again.";
                break;
            case 'FH-INVALID-KEY';
                $error = "Invalid token key. Please try again.";
                break;
            case 'FH-MAX-ATTEMPT';
                $error = "You have reached the Maximum attempts. Please try after 5 minutes.";
                break;
            case 'FH-LOGIN';
                $error = "Please enter a valid email ID.";
                break;
            default;
                $error = "Invalid Request or We are unable to load the data.";
                break;
        }
        return $error;
    }

    public static function get_upload_url()
    {
        $image_url = \Yii::$app->urlManager->createAbsoluteUrl('backend/uploads');
        $image_url = str_replace('/api/web', '', $image_url);
        return $image_url = str_replace('/uploads', '/', $image_url);
    }

    public static function sendpush($method, $data)
    {
        $url = 'https://cp.pushwoosh.com/json/1.3/' . $method;
        $request = json_encode(['request' => $data]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if (defined('PW_DEBUG') && self::$push_debug) {
            print "[PW] request: $request\n";
            print "[PW] response: $response\n";
            print "[PW] info: " . print_r($info, true);
        }

        return $info;
    }

    public static function get_log($post_data = 0, $get_data = 0, $file_data = 0)
    {

        $base_url = \Yii::$app->basePath;
        $base_url = $base_url . '/web/';
        $file = $base_url . 'apilog.txt';
        //        $fp = fopen($file, 'w');
        $fp = fopen($file, 'a+');
        fwrite($fp, "============= " . date('d D M Y h:i:sa') . " ===============" . "\r\n\n");
        if ($post_data) {
            fwrite($fp, "POST Data: " . json_encode($post_data) . "\r\n\n");
        }
        if ($get_data) {
            fwrite($fp, "GET Data: " . json_encode($get_data) . "\r\n\n");
        }
        if ($file_data) {
            fwrite($fp, "FILE Data: " . json_encode($file_data) . "\r\n\n");
        }
        fwrite($fp, "============================" . "\r\n\n");
        fclose($fp);
    }

    public function aes_decrypt($enc_string)
    {
        //        $iv = substr($cypher, 0, 32);
        //        $key = substr($cypher, 32, 32);
        //        $ciphertext = substr($cypher, 64);
        //        $decrypted = openssl_decrypt($ciphertext, 'AES-128-CBC', hex2bin($key), 0, hex2bin($iv));
        //        $decrypted = trim($decrypted);
        //        return $decrypted;
        $key = hex2bin("0123456789abcdef0123456789abcdef");
        $iv = hex2bin("abcdef9876543210abcdef9876543210");
        $decrypted = openssl_decrypt($enc_string, 'AES-128-CBC', $key, 0, $iv);
        return trim($decrypted);
    }

    public function is_valid_date($date)
    {
        return date('Y-m-d H:i:s', strtotime($date)) === $date;
    }
    public function createJwtToken($uid)
    {
        $time = time();
        $payload = array(
            "iss" => "",
            "aud" => "",
            "iat" => $time,
            "uid" => $uid,
            "exp" => $time + self::$jwtExp,
        );
        return $this->jwtEncode($payload);
    }
    public function jwtEncode($payload)
    {
        $jwt = JWT::encode($payload, self::$jwtKey, self::$jwtAlgo);
        return $jwt;
    }
    public static function jwtDecodeBody($body)
    {
        //return (array)  JWT::decode($body, new Key(self::$jwtKey, self::$jwtAlgo));
        return json_decode(json_encode(JWT::decode($body, new Key(self::$jwtKey, self::$jwtAlgo))), true);
    }
    public static function jwtDecode($token, $request)
    {
        $requestArr = ['get-login-screen', 'login', 'verifyotp', 'check-updates', 'get-codes', 'get-updated-data', 'update-activity', 'get-brands', 'get-categories', 'get- moments', 'get-occasions', 'sync-codes', 'get-products', 'sendmail', 'tracksync', 'save-speedrail'];
        try {
            $res = JWT::decode($token, new Key(self::$jwtKey, self::$jwtAlgo));
            if (in_array($request, $requestArr) && $res->request != $request) {
                throw new UnauthorizedHttpException("Invalid Request.");
            }

            $current_time = strtotime(date('Y-m-d H:i:s'));

            $expired_time =  strtotime($res->expiry);

            $min = $expired_time - $current_time;

            if ($min <= 0) {
                throw new ExpiredException('Expired token');
            }
        } catch (SignatureInvalidException $e) {
            return $e->getMessage();
        } catch (BeforeValidException $e) { // Also tried JwtException
            return $e->getMessage();
        } catch (ExpiredException $e) {
            return $e->getMessage();
        } catch (Exception $e) {
            return "Invalid Token.";
        }
        return $res;
    }



    public static function encode_response_data($data)
    {
        return JWT::encode($data, self::$jwtKey, self::$jwtAlgo);
    }

    public static function validateAuthToken($token, $request)
    {
        $validate_token = self::jwtDecode($token, $request);
        if (is_string($validate_token)) {
            throw new UnauthorizedHttpException($validate_token);
        }

        if (!in_array($request, ['login', 'get-login-screen', 'verifyotp'])) {
            $token = "";
            if (isset($validate_token->{'access-token'})) {
                $token = $validate_token->{'access-token'};
            } elseif (isset($validate_token->{'token'})) {
                $token = $validate_token->{'token'};
            }
            $educator = Educators::findIdentityByAccessToken($token);
            if ($educator) {
                return $educator->edu_id;
            }
            // return 49;
            throw new UnauthorizedHttpException("Invalid User.");
        }
        return 0;
    }
    public function getErrors($model)
    {
        $message = array();

        foreach ($model->getErrors() as $error) {
            $message[] = $error[0];
        } //$model->getErrors() as $error
        throw new \Exception(implode('<br/>', $message));
    }

    public function getErrorsList($model, $implode = "\n")
    {
        $message = array();
        foreach ($model->getErrors() as $error) {
            $message[] = $error[0];
        } //$model->getErrors() as $error
        return implode($implode, $message);
    }
}
