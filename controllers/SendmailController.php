<?php

namespace app\controllers;

use app\models\TrailSubmissions;

use yii\db\Query;

class SendmailController extends \yii\web\Controller
{

    public $defaultAction = 'pushmail';

    public function actionPushmail()
    {
        $TrailSubmissions = TrailSubmissions::find()->where(['status' => 'pending', 'request_type' => 'submit'])->all(); // find all requests
        if (count($TrailSubmissions) > 0) {
            foreach ($TrailSubmissions as $req) {
                $user_random_id = $req->user_random_id;
                $Request_id = $req->id;
                $email = \Yii::$app->api->aes_decrypt($req->email);
                $query = new Query;
                $query->select(['products.pro_name', 'products.pro_des', 'products.pro_id', 'submission_products.req_id', 'SUBSTR(products.pro_img ,21) as pro_img', 'products.des_url', 'products.cta', 'products.brand_name', 'products.sub_name', 'products.pro_type'])
                    ->from('submission_products')
                    ->join('INNER JOIN', 'products', 'submission_products.prod_id = products.pro_id')
                    ->join('INNER JOIN', 'brands', 'brands.brand_id = products.brand_id ')
                    ->where('submission_products.req_id = :id', [':id' => $Request_id]);

                $command = $query->createCommand();
                $data = $command->queryAll();
                $is_mailsend = \Yii::$app->mailer->compose(['html' => 'mail-html'], ['data' => $data, 'user_random_id' => $user_random_id, 'edu_id' => $req['edu_id']])
                    ->setFrom([\Yii::$app->params['smtpFrom'] => 'DIAGEO'])
                    ->setTo($email)
                    ->setSubject('Discover A Drink : DIAGEO')
                    ->send();
                if ($is_mailsend) {
                    $req->status = TrailSubmissions::SEND_STATUS; // request process completed and mail send 
                    $req->mail_send_time = date('Y-m-d H:i:s'); // mail send time
                    $req->save();
                    //                    $isdelete = SubmissionProducts::deleteAll('req_id = :req_id', [':req_id' => $req->id]);
                    //                    if ($isdelete) {
                    //                        $req->delete();
                    //                    }
                }
            }
            echo "success";
            exit();
        }
    }
}
