<?php

namespace app\controllers;


use app\models\MailTrack;

use app\models\Cocktail;
use app\models\Marques;
use app\models\ClickTrack;


class TrackmailController extends \yii\web\Controller
{

    public function actionIndex($uid = 0, $edu_id = 0)
    {
        $track = MailTrack::find()->where(['user_random_id' => $uid, 'edu_id' => $edu_id])->one();
        if (!$track) {
            $MailTrack = new MailTrack;
            $MailTrack->user_random_id = $uid;
            $MailTrack->edu_id = $edu_id;
            $MailTrack->open_date = date('Y-m-d H:i:s');
            $MailTrack->save();
        }
        header("Content-Type: image/png"); // it will return image 
        readfile("../web/img/diageo-logo.png");
        exit();
    }

    public function actionViewtrack($proid, $type, $edu, $urid)
    {

        $cocktailId = null;
        $marqueId = null;
        $brand_id = null;
        if ($type == 'cocktail') {
            $cocktailId = $proid;
            //$Product = Cocktail::find()->where(['id' => $proid])->one();
            $Product = Cocktail::find()->select(["brand_details.id as brand_id", "cocktail.id", "cocktail.created_at", "cocktail.updated_at", "cocktail.url"])->joinWith(['marques.brand'])->where(['cocktail.id' => $proid])->one();

            $brand_id = $Product->marques->brand_id;
        } elseif ($type == 'marque') {
            $marqueId = $proid;
            $Product = Marques::find()->where(['id' => $proid])->one();
            $brand_id = $Product->brand_id;
        }

        // $Product = Products::find()->where(['pro_id' => $proid])->one();
        if ($Product) {
            $track = ClickTrack::find()->where(['brand_id' => $brand_id, 'edu_id' => $edu, 'user_random_id' => $urid])->one();
            if (!$track) {
                $ClickTrack = new ClickTrack;
                $ClickTrack->pro_id = null;
                $ClickTrack->cocktail_id = $cocktailId;
                $ClickTrack->marque_id = $marqueId;
                $ClickTrack->edu_id = $edu;
                $ClickTrack->user_random_id = $urid;
                $ClickTrack->brand_id = $brand_id;
                $ClickTrack->click_date = date('Y-m-d H:i:s');
                $ClickTrack->save();
            }
            $this->redirect($Product->url);
        }
    }
}
