<?php

namespace app\components;

use Yii;
use yii\base\Component;
use app\models\UserSync;


class Cms extends Component
{
    public static function formShowHide($a)
    {
        $getData = Yii::$app->getRequest()->getQueryParam($a);
        $isSearch = "none";
        if (is_array($getData) && count($getData) > 0) {
            foreach ($getData as $key) {
                if (isset($key) && !empty($key)) {
                    $isSearch = "block";
                    break;
                } else {
                    continue;
                }
            }
        }
        return $isSearch;
    }

    public static function updateSyncDataTime()
    {
        $model = UserSync::findOne(1);
        $model->save();
    }
    public static function getIp($recover_ip = '')
    {
        $ip = "";
        if (php_sapi_name() == "cli" && $recover_ip == '') {

            $ip = sprintf("%u", ip2long(gethostbyname(gethostname())));
        } //php_sapi_name() == "cli" && $recover_ip == ''


        else {

            $ip = Yii::$app->getRequest()->getUserIP();

            if ($ip == 'fe80::45c9:d459:2765:e497' || $ip == 'fe80::3c5c:2d6c:3f57:fe9a' || $ip == "::1") {

                $ip = "127.0.0.1";
            } //$ip == 'fe80::45c9:d459:2765:e497' || $ip == 'fe80::3c5c:2d6c:3f57:fe9a'

        }
        if ($ip == "") {
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        }
        return $ip;
    }
    public function uploadFile($category, $image, $file_name = "")
    {
        $folder = Yii::$app->basePath . '/web/uploads/' . $category;
        if (!file_exists($folder)) {
            mkdir($folder, 0755, true);
        }
        // if ($file_name != ""  && file_exists($folder . '/' . $file_name)) {
        //     unlink($folder . '/' . $file_name);
        //     $file_name = "";
        // }
        if ($file_name == "") {
            $file_name  = $category . '_' . time() . '.png';
        }

        list($type, $image) = explode(';', $image);
        list(, $image)      = explode(',', $image);

        $image = base64_decode($image);

        $path = Yii::$app->basePath . '/web/uploads/' . $category . '/' . $file_name;

        file_put_contents($path, $image);
        $im = imagecreatefrompng($path);
        $cropped = imagecropauto($im, IMG_CROP_SIDES);

        if ($cropped !== false) { // in case a new image resource was returned
            imagedestroy($im);    // we destroy the original image
            $im = $cropped;       // and assign the cropped image to $im
        }
        imagealphablending($im, false);
        imagesavealpha($im, true);
        imagepng($im, $path);
        imagedestroy($im);

        return $file_name;
    }
}
