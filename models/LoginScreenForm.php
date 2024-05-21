<?php

namespace app\models;

use Yii;
use yii\base\Model;

/*
 * ContactForm is the model behind the contact form.
 */

class LoginScreenForm extends Model
{

    public $screen;
    public $login_screen;

    /*
     * @return array the validation rules.
     */
    public function rules()
    {
        return [

            [['login_screen'], 'safe'],

            ['screen', 'safe'],
        ];
    }

    public function update()
    {
        if (!$this->validate()) {
            return null;
        }

        $loginScreen = LoginScreen::find()->one();

        if (empty($loginScreen)) {
            $loginScreen = new LoginScreen();
        }

        $oldPic = $loginScreen->image;
        $loginScreen->image = Yii::$app->cms->uploadFile('login_screen', $this->screen, $oldPic);


        if (!$loginScreen->save()) {
            return false;
        }


        return true;
    }
}
