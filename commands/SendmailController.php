<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\TrailSubmissions;
use app\models\SubmissionProducts;
use yii\db\Query;
use yii\helpers\Console;

class SendmailController extends Controller
{

    public $defaultAction = 'pushmail';

    public function actionPushmail()
    {

        $TrailSubmissions = TrailSubmissions::find()->where('status = :status', [':status' => 'pending'])->all(); // find all requests
        if (count($TrailSubmissions) > 0) {
            foreach ($TrailSubmissions as $req) {
                $Request_id = $req->id;
                $email = $req->email;
                $query = new Query;
                $query->select(['products.pro_name'])
                    ->from('submission_products')
                    ->join('INNER JOIN', 'products', 'submission_products.prod_id = products.pro_id')
                    ->join('INNER JOIN', 'brands', 'brands.brand_id = products.brand_id ')
                    ->where('submission_products.req_id = :id', [':id' => $Request_id]);
                $command = $query->createCommand();
                $data = $command->queryAll();
                \Yii::$app->mailer->compose(['html' => 'product-list-html_test'], ['name' => 'Rahul', 'data' => $data])
                    ->setFrom([\Yii::$app->params['smtpFrom'] => 'DIAGEO'])
                    ->setTo($email)
                    ->setSubject('Discover A Drink : DIAGEO')
                    ->send();
                $req->status = TrailSubmissions::SEND_STATUS; // request process completed and mail send 
                $req->mail_send_time = date('Y-m-d H:i:s'); // mail send time
                $req->save();
            }
            $this->stdout("Mail send successfully.\n", Console::BOLD);
        } else {
            $name = $this->ansiFormat('No Request Pending.', Console::FG_YELLOW);
            $this->stdout($name, Console::BG_RED);
            //            return ExitCode::UNSPECIFIED_ERROR;
        }
    }
}
