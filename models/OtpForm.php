<?php

namespace app\models;

use Yii;
use yii\base\Model;

/*
 * ContactForm is the model behind the contact form.
 */

class OtpForm extends Model {

    public $otp;

    /*
     * @return array the validation rules.
     */

    public function rules() {
        return [
            [['otp'], 'required'],
            [['otp'], 'checkotp'],
        ];
    }

    public function checkotp($attribute, $params) {
        $key = $_REQUEST['key'];
        if ($this->otp && $key) {
            $otp_model = BackendOtpDetails::find()->where(['key' => $key])->one();
//            var_dump($otp_model->otp);
//            var_dump($this->otp);
//            die;
            if ($otp_model->otp != $this->otp) {
                $this->addError($attribute, 'Invalid OTP');
            }
        }
    }

}
