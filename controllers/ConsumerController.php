<?php

namespace app\controllers;

use Yii;

use app\models\SpeedRails;
use app\models\Cocktail;
use app\models\Marques;
use app\models\PinQrTrack;
use app\models\PinPull;

use app\models\ConsumerClickTrack;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

use yii\helpers\Url;
use app\models\PinWeblog;
use Knp\Snappy\Pdf;
use yii\web\TooManyRequestsHttpException;

/**
 * AdminuserController implements the CRUD actions for User model.
 */
class ConsumerController extends Controller
{

    /**
     * {@inheritdoc}
     */
    //public $defaultAction = 'pin-verification';
    public function actionIndex()
    {

        return $this->redirect(['consumer/pin-verification'])->send();
        return $this->renderPartial('landing');
    }

    public function actionCustomerRecommendation()
    {
        $id = Yii::$app->request->get('id');
        $pin = Yii::$app->request->get('pin');
        $mode = Yii::$app->request->get('mode');
        $pinWeblog = new PinWeblog();
        $check = $pinWeblog->check($pin);
        if (!$check) {
            throw new TooManyRequestsHttpException();
        }

        if (!empty($pin)) {

            $result = SpeedRails::find()->where(['pin' => $pin])->one();
            if (empty($result)) {
                if ($mode === 'qr' && $pin) {
                    $this->addTracking($pin, 'qr', 'loading_page_visit');
                }

                if ($mode === 'pin' && $pin) {
                    $this->addTracking($pin, 'pin', 'loading_page_visit');
                }
                return $this->renderPartial('error');
            } else {

                if ($mode === 'qr') {
                    $this->addTracking($pin, 'qr', 'consumer_page_visit');
                }
                if ($mode === 'pin') {
                    $this->addTracking($pin, 'pin', 'consumer_page_visit');
                }
            }
            $id = $result->id;
        }

        if (empty($pin) && empty($id)) {
            return $this->renderPartial('error');
        }

        $connection = \Yii::$app->db;
        $data = $connection->createCommand("SELECT sp.type, sp.speedrail_id, sp.product_id, m.name as marque_name,c.name as cocktail_name, m.description, c.ingredients, c.instructions, c.url as cocktail_url, m.url as marque_url, c.image as cocktail_image, m.image as marque_image FROM `speedrail_products` sp
            LEFT JOIN  marques m ON m.id = sp.`product_id` AND sp.`type`= 'marque'
            LEFT JOIN  cocktail c ON c.id = sp.`product_id` AND sp.`type`= 'cocktail'
            WHERE sp.speedrail_id = :sp_id")
            ->bindValue(':sp_id', $id)
            ->queryAll();


        return $this->renderPartial('customer', ['data' => $data]);
    }

    public function actionLoading()
    {
        $mode = Yii::$app->request->get('mode');
        $pin = Yii::$app->request->get('pin');
        if ($mode === 'qr' && $pin) {
            $this->addTracking($pin, 'qr', 'loading_page_visit');
        }

        if ($mode === 'pin' && $pin) {
            $this->addTracking($pin, 'pin', 'loading_page_visit');
        }
        return $this->renderPartial('error');
    }

    public function actionPinVerification()
    {
        Yii::$app->cache->flush();
        return $this->renderPartial('pinverification');
    }

    public function actionVerifyOtp()
    {
        $data = Yii::$app->request->post();
        $pin = (int) implode($data['digit']);
        return $this->redirect(['customer-recommendation', 'pin' => $pin, 'mode' => 'pin']);
    }

    /**
     * Finds the Market model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Market the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cocktail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function addTracking($pin, $pin_mode, $visit_type)
    {
        $qrTrack = new PinQrTrack();
        $qrTrack->pin = $pin;

        $pinPullNumber = pinPull::find()->where(['pin_number' => $pin])->andWhere(['<>', 'allocated_to', 0])->one();
        $isPinExist = empty($pinPullNumber) ? 0 : 1;
        if ($isPinExist) {
            if ($pin_mode === 'pin') {
                $qrTrack->pin_mode = 1;
            } else {
                $qrTrack->qr_mode = 1;
            }
            if ($visit_type === 'consumer_page_visit') {
                $qrTrack->consumer_page_visit = 1;
            } else {
                $qrTrack->loading_page_visit = 1;
            }

            $result = $qrTrack->save();
        }
    }

    public function actionBrandTrack()
    {
        $sp_id = Yii::$app->request->post('speed_rail_id');
        $prod_id = Yii::$app->request->post('product_id');
        $prod_type = Yii::$app->request->post('product_type');
        $product = '';

        if ($prod_type == 'cocktail') {
            $data = Cocktail::find()->select(`brands.id as brand_id`, `cocktail.id`, `cocktail.created_at`, `cocktail.updated_at`)->joinWith(['marques.brand'])->where(['cocktail.id' => $prod_id])->one();
            $brand_id = $data->marques->brand_id;
        } else {
            $data = Marques::find()->where(['id' => $prod_id])->one();
            $brand_id = $data->brand_id;
        }

        $data = ConsumerClickTrack::find()->where(['speedrail_id' => $sp_id])->andWhere(['brand_id' => $brand_id])->one();
        if (empty($data)) {
            $addtrack = new ConsumerClickTrack();
            $addtrack->speedrail_id = $sp_id;
            $addtrack->brand_id = $brand_id;
            $addtrack->save();
        }
        $result = array('status' => 'success', 'msg' => 'succesfully tracked');
        echo json_encode($result);
        exit;
    }

    public function actionGeneratePdf()
    {
        $id = Yii::$app->request->get('id');

        $connection = \Yii::$app->db;
        $baseUrl = Yii::getAlias('@web');

        $assets = $baseUrl . '/assets/';
        $images = $assets . 'images/';
        $js = $assets . 'js/';
        $css = $assets . 'css/';
        //set_time_limit(30);

        $data = $connection->createCommand("SELECT sp.type, sp.speedrail_id, sp.product_id, m.name as marque_name,c.name as cocktail_name, m.description, c.ingredients, c.instructions, c.url as cocktail_url, m.url as marque_url, c.image as cocktail_image, m.image as marque_image FROM `speedrail_products` sp
            LEFT JOIN  marques m ON m.id = sp.`product_id` AND sp.`type`= 'marque'
            LEFT JOIN  cocktail c ON c.id = sp.`product_id` AND sp.`type`= 'cocktail'
            WHERE sp.speedrail_id = :sp_id")
            ->bindValue(':sp_id', $id)
            ->queryAll();
        $newData['data'] = $data;

        return $this->renderPartial('speedrailpdf', $newData);

        exit;
    }

    public function actionGetPdf()
    {
        $id = Yii::$app->request->get('id');
        $basedirectory = Yii::getAlias('@vendor');
        $snappy = new Pdf($basedirectory . '/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64');


        $url = Url::toRoute(['consumer/generate-pdf', 'id' => $id], 'https');


        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="file.pdf"');


        $headerurl = Yii::$app->getUrlManager()->createUrl('consumer/get-header');
        $snappy->setOption('margin-top', 7);
        $snappy->setOption('margin-bottom', 7);
        $snappy->setOption('margin-left', 0);
        $snappy->setOption('margin-right', 0);

        $snappy->setOption('header-html', $this->renderPartial('speedrail-header'));
        $snappy->setOption('footer-html', $this->renderPartial('speedrail-footer'));
        echo $snappy->getOutput($url);
        exit;
    }

    public function actionGetHeader()
    {
        $this->layout = false;
        return $this->render('speedrail-header');
    }
}
