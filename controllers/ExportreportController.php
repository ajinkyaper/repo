<?php

namespace app\controllers;

use Yii;
use app\models\Educators;
use app\models\ProTrack;
use app\models\SubmissionProducts;

use app\models\Marques;
use app\models\OccasionV3;

use app\models\MomentV3;
use app\models\MailTrack;
use app\models\ClickTrack;
use app\models\ReportForm;
use app\models\SpeedRails;

use app\models\TrailSubmissions;
use yii\db\Query;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ExportreportController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        ini_set('max_execution_time', '3600');
        $model = new ReportForm();
        $this->layout = 'main_new';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            /*             * ************************************************** Sheet One ************************************ */
            $from_date = $model->from_date;
            $to_date = $model->to_date;
            $start_date = date('Y-m-d H:i:s', strtotime($from_date));
            $end_date = date('Y-m-d 23:59:59', strtotime($to_date));
            $connection = \Yii::$app->db;
            $query = new Query;
            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(18);
            $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(18);
            $spreadsheet->getActiveSheet()->setTitle('Engagement');
            $spreadsheet->getActiveSheet()->setCellValue('A1', 'Market');
            $spreadsheet->getActiveSheet()->setCellValue('B1', 'Educator');
            $spreadsheet->getActiveSheet()->setCellValue('C1', 'Consumers Engaged');
            $spreadsheet->getActiveSheet()->setCellValue('D1', 'Consumers that added marques  to the Speed Rail');
            $spreadsheet->getActiveSheet()->setCellValue('E1', 'Consumers that added recipes to the SpeedRail');
            $spreadsheet->getActiveSheet()->setCellValue('F1', 'Consumers that opted-in to the email delivery');
            $spreadsheet->getActiveSheet()->setCellValue('G1', 'Session Length (mm:ss)');
            $spreadsheet->getActiveSheet()->setCellValue('H1', 'Consumers who opened the email');
            $spreadsheet->getActiveSheet()->setCellValue('I1', '# of click-thrus from the email');
            $spreadsheet->getActiveSheet()->setCellValue('J1', '# pin Generated');

            $sheet1Query = $connection->createCommand($this->getSheet1Query())
                ->bindValue(':from_date', $start_date)
                ->bindValue(':to_date', $end_date)
                ->queryAll();

            $row = 2;
            $data_row = 3;
            $city = [];
            foreach ($sheet1Query as $s1Value) {
                if (!isset($city[$s1Value['city']])) {
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $row, $s1Value['city']);
                    $city[$s1Value['city']] = $s1Value['city'];
                    $row++;
                }
                // $spreadsheet->getActiveSheet()->setCellValue('A' . $row, $s1Value['city']);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $row, $s1Value['edu_name']);
                $spreadsheet->getActiveSheet()->setCellValue('C' . $row, (int)$s1Value['consumers_engaged']); // print educator name
                $spreadsheet->getActiveSheet()->setCellValue('D' . $row, (int)$s1Value['marque_count']); // print marque added on speed rail count by educator
                $spreadsheet->getActiveSheet()->setCellValue('E' . $row, (int)$s1Value['cocktail_count']); // print marque added on speed rail count by educator
                $spreadsheet->getActiveSheet()->setCellValue('F' . $row, (int)$s1Value['email_delivery']); // print count of consumers prefer to sumit by educator

                $spreadsheet->getActiveSheet()->setCellValue('G' . $row, $s1Value['session_length']); // print total session length by educator

                $spreadsheet->getActiveSheet()->setCellValue('H' . $row, (int)$s1Value['email_opened']); // print total count of consumers opend mail by educator

                $spreadsheet->getActiveSheet()->setCellValue('I' . $row, (int)$s1Value['email_click']); // print total count of consumers opend mail by educator

                $spreadsheet->getActiveSheet()->setCellValue('J' . $row, (int)$s1Value['pin_generated']); // print total count of pin generated 
                $row++;
            }
            //goto blank;
            /*             * ************************************************** Sheet Two ************************************ */
            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex(1);
            $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(18);
            $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(18);
            $spreadsheet->getActiveSheet()->setTitle('Occasions');
            $spreadsheet->getActiveSheet()->setCellValue('A1', 'Consumers that preferred:');
            $spreadsheet->getActiveSheet()->mergeCells("A1:I1");
            $spreadsheet->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->mergeCells("B2:C2");
            $spreadsheet->getActiveSheet()->setCellValue('B2', 'Familiar Moments (FM)');
            $spreadsheet->getActiveSheet()->mergeCells("D2:E2");
            $spreadsheet->getActiveSheet()->setCellValue('D2', 'Moments Worth Enhancing (MWE)');
            $spreadsheet->getActiveSheet()->mergeCells("F2:G2");
            $spreadsheet->getActiveSheet()->setCellValue('F2', 'Moments To Connect (MtC)');
            $spreadsheet->getActiveSheet()->mergeCells("H2:I2");
            $spreadsheet->getActiveSheet()->setCellValue('H2', 'Upbeat Moments (UM)');
            $spreadsheet->getActiveSheet()->setCellValue('B3', 'Everyday evening at home');
            $spreadsheet->getActiveSheet()->setCellValue('C3', 'Fun relaxing evening at home');
            $spreadsheet->getActiveSheet()->setCellValue('D3', 'Indulgent moment at home');
            $spreadsheet->getActiveSheet()->setCellValue('E3', 'Planned Special Meal');
            $spreadsheet->getActiveSheet()->setCellValue('F3', 'Easygoing Hangout at home ');
            $spreadsheet->getActiveSheet()->setCellValue('G3', 'Family meal together');
            $spreadsheet->getActiveSheet()->setCellValue('H3', 'High energy hangout at home');
            $spreadsheet->getActiveSheet()->setCellValue('I3', 'Fun meal at home');
            $spreadsheet->getActiveSheet()->getStyle('B2:I2')->getAlignment()->setHorizontal('center');
            $occ = [11 => 'B', 12 => 'C', 13 => 'D', 14 => 'E', 15 => 'F', 16 => 'G', 17 => 'H', 18 => 'I'];
            $total = [11 => 0, 12 => 0, 13 => 0, 14 => 0, 15 => 0, 16 => 0, 17 => 0, 18 => 0];
            $data = $connection->createCommand($this->getSheet2Query())
                ->bindValue(':from_date', $start_date)
                ->bindValue(':to_date', $end_date)
                ->queryAll();
            $row = 4;
            $current_user = [];
            foreach ($data as $value) {
                if (!isset($current_user[$value['edu_id']])) {
                    $current_user[$value['edu_id']] = $value['edu_id'];
                    $row++;
                }
                $spreadsheet->getActiveSheet()->setCellValue('A' . $row, $value['edu_name']);
                $spreadsheet->getActiveSheet()->setCellValue($occ[$value['occasion_id']] . $row, (int)$value['consumers_engaged']);
                $total[$value['occasion_id']] = $total[$value['occasion_id']] + (int)$value['consumers_engaged'];
            }
            $spreadsheet->getActiveSheet()->setCellValue('A4', 'All Educators');
            foreach ($total as $occ_id => $final_total) {
                $spreadsheet->getActiveSheet()->setCellValue($occ[$occ_id] . '4', $final_total);
            }

            /*             * ************************************************** Sheet Three ************************************ */
            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex(2);
            $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(18);
            $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(18);
            $spreadsheet->getActiveSheet()->setTitle('Marques');
            $spreadsheet->getActiveSheet()->setCellValue('A1', 'marque');
            $spreadsheet->getActiveSheet()->mergeCells("A1:B2");
            $spreadsheet->getActiveSheet()->getStyle('A1:B2')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('A1:B2')->getAlignment()->setVertical('center');
            $spreadsheet->getActiveSheet()->getStyle('C1:W1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('C2:W2')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('C3:W3')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->mergeCells("C1:J1");
            $spreadsheet->getActiveSheet()->setCellValue('C1', 'Consumers that viewed it on:');

            $spreadsheet->getActiveSheet()->mergeCells("K1:O1");
            $spreadsheet->getActiveSheet()->setCellValue('K1', 'Consumers that added it to Speed Rail by Order:');

            $spreadsheet->getActiveSheet()->mergeCells("C2:D2");
            $spreadsheet->getActiveSheet()->setCellValue('C2', 'Familiar Moments (FM)');
            $spreadsheet->getActiveSheet()->mergeCells("E2:F2");
            $spreadsheet->getActiveSheet()->setCellValue('E2', 'Moments Worth Enhancing (MWE)');
            $spreadsheet->getActiveSheet()->mergeCells("G2:H2");
            $spreadsheet->getActiveSheet()->setCellValue('G2', 'Moments To Connect (MtC)');
            $spreadsheet->getActiveSheet()->mergeCells("I2:J2");
            $spreadsheet->getActiveSheet()->setCellValue('I2', 'Upbeat Moments (UM)');

            $spreadsheet->getActiveSheet()->setCellValue('A3', 'Brand name');
            $spreadsheet->getActiveSheet()->setCellValue('B3', 'Variant name');
            $spreadsheet->getActiveSheet()->setCellValue('C3', 'Everyday evening at home');
            $spreadsheet->getActiveSheet()->setCellValue('D3', 'Fun relaxing evening at home');
            $spreadsheet->getActiveSheet()->setCellValue('E3', 'Indulgent moment at home');
            $spreadsheet->getActiveSheet()->setCellValue('F3', 'Planned Special Meal');
            $spreadsheet->getActiveSheet()->setCellValue('G3', 'Easygoing Hangout at home ');
            $spreadsheet->getActiveSheet()->setCellValue('H3', 'Family meal together');
            $spreadsheet->getActiveSheet()->setCellValue('I3', 'High energy hangout at home');
            $spreadsheet->getActiveSheet()->setCellValue('J3', 'Fun meal at home');

            $spreadsheet->getActiveSheet()->mergeCells("K2:K3");
            $spreadsheet->getActiveSheet()->setCellValue('K2', '1');

            $spreadsheet->getActiveSheet()->mergeCells("L2:L3");
            $spreadsheet->getActiveSheet()->setCellValue('L2', '2');

            $spreadsheet->getActiveSheet()->mergeCells("M2:M3");
            $spreadsheet->getActiveSheet()->setCellValue('M2', '3');

            $spreadsheet->getActiveSheet()->mergeCells("N2:N3");
            $spreadsheet->getActiveSheet()->setCellValue('N2', '4');

            $spreadsheet->getActiveSheet()->mergeCells("O2:O3");
            $spreadsheet->getActiveSheet()->setCellValue('O2', '5');
            $occ = [11 => 'C', 12 => 'D', 13 => 'E', 14 => 'F', 15 => 'G', 16 => 'H', 17 => 'I', 18 => 'J'];

            $data = $connection->createCommand($this->getSheet3Query())
                ->bindValue(':from_date', $start_date)
                ->bindValue(':to_date', $end_date)
                ->queryAll();
            $row = 3;
            $current_marque = [];
            foreach ($data as $value) {
                if (!isset($current_marque[$value['marque_id']])) {
                    $current_marque[$value['marque_id']] = $value['marque_id'];
                    $row++;
                }
                $consumer_view = (is_numeric($value['consumer_view'])) ? $value['consumer_view'] : 0;

                $spreadsheet->getActiveSheet()->setCellValue('A' . $row, $value['brand_name']);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $row, $value['variant_name']);

                $spreadsheet->getActiveSheet()->setCellValue('C' . $row, 0);
                $spreadsheet->getActiveSheet()->setCellValue('D' . $row, 0);
                $spreadsheet->getActiveSheet()->setCellValue('E' . $row, 0);
                $spreadsheet->getActiveSheet()->setCellValue('F' . $row, 0);
                $spreadsheet->getActiveSheet()->setCellValue('G' . $row, 0);
                $spreadsheet->getActiveSheet()->setCellValue('H' . $row, 0);
                $spreadsheet->getActiveSheet()->setCellValue('I' . $row, 0);
                $spreadsheet->getActiveSheet()->setCellValue('J' . $row, 0);

                $spreadsheet->getActiveSheet()->setCellValue($occ[$value['occasion_id']] . $row, $consumer_view);
                $spreadsheet->getActiveSheet()->setCellValue("K" . $row, $value['o1']);
                $spreadsheet->getActiveSheet()->setCellValue("L" . $row, $value['o2']);
                $spreadsheet->getActiveSheet()->setCellValue("M" . $row, $value['o3']);
                $spreadsheet->getActiveSheet()->setCellValue("N" . $row, $value['o4']);
                $spreadsheet->getActiveSheet()->setCellValue("O" . $row, $value['o5']);
            }


            /*             * ************************************************** Sheet Four ************************************ */

            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex(3);
            $spreadsheet->getActiveSheet()->setTitle('Cocktails');
            $spreadsheet->getActiveSheet()->setCellValue('A1', 'cocktail');
            $spreadsheet->getActiveSheet()->mergeCells("A1:B2");
            $spreadsheet->getActiveSheet()->getStyle('A1:B2')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('A1:B2')->getAlignment()->setVertical('center');
            $spreadsheet->getActiveSheet()->getStyle('C1:W1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('C2:W2')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('C3:W3')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->mergeCells("C1:J1");
            $spreadsheet->getActiveSheet()->setCellValue('C1', 'Consumers that viewed it on:');

            $spreadsheet->getActiveSheet()->mergeCells("K1:O1");
            $spreadsheet->getActiveSheet()->setCellValue('K1', 'Consumers that added it to Speed Rail by Order:');
            $spreadsheet->getActiveSheet()->mergeCells("C2:D2");
            $spreadsheet->getActiveSheet()->setCellValue('C2', 'Familiar Moments (FM)');
            $spreadsheet->getActiveSheet()->mergeCells("E2:F2");
            $spreadsheet->getActiveSheet()->setCellValue('E2', 'Moments Worth Enhancing (MWE)');
            $spreadsheet->getActiveSheet()->mergeCells("G2:H2");
            $spreadsheet->getActiveSheet()->setCellValue('G2', 'Moments To Connect (MtC)');
            $spreadsheet->getActiveSheet()->mergeCells("I2:J2");
            $spreadsheet->getActiveSheet()->setCellValue('I2', 'Upbeat Moments (UM)');

            $spreadsheet->getActiveSheet()->setCellValue('A3', 'Brand name');
            $spreadsheet->getActiveSheet()->setCellValue('B3', 'Variant name');
            $spreadsheet->getActiveSheet()->setCellValue('C3', 'Everyday evening at home');
            $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(18);
            $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(18);
            $spreadsheet->getActiveSheet()->setCellValue('D3', 'Fun relaxing evening at home');
            $spreadsheet->getActiveSheet()->setCellValue('E3', 'Indulgent moment at home');
            $spreadsheet->getActiveSheet()->setCellValue('F3', 'Planned Special Meal');
            $spreadsheet->getActiveSheet()->setCellValue('G3', 'Easygoing Hangout at home ');
            $spreadsheet->getActiveSheet()->setCellValue('H3', 'Family meal together');
            $spreadsheet->getActiveSheet()->setCellValue('I3', 'High energy hangout at home');
            $spreadsheet->getActiveSheet()->setCellValue('J3', 'Fun meal at home');

            $spreadsheet->getActiveSheet()->mergeCells("K2:K3");
            $spreadsheet->getActiveSheet()->setCellValue('K2', '1');

            $spreadsheet->getActiveSheet()->mergeCells("L2:L3");
            $spreadsheet->getActiveSheet()->setCellValue('L2', '2');

            $spreadsheet->getActiveSheet()->mergeCells("M2:M3");
            $spreadsheet->getActiveSheet()->setCellValue('M2', '3');

            $spreadsheet->getActiveSheet()->mergeCells("N2:N3");
            $spreadsheet->getActiveSheet()->setCellValue('N2', '4');

            $spreadsheet->getActiveSheet()->mergeCells("O2:O3");
            $spreadsheet->getActiveSheet()->setCellValue('O2', '5');

            $data = $connection->createCommand($this->getSheet4Query())
                ->bindValue(':from_date', $start_date)
                ->bindValue(':to_date', $end_date)
                ->queryAll();
            $row = 3;
            $current_cocktail = [];
            foreach ($data as $value) {
                if (!isset($current_cocktail[$value['cocktail_id']])) {
                    $current_cocktail[$value['cocktail_id']] = $value['cocktail_id'];
                    $row++;
                }
                $consumer_view = (is_numeric($value['consumer_view'])) ? $value['consumer_view'] : 0;
                $spreadsheet->getActiveSheet()->setCellValue('A' . $row, $value['brand_name']);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $row, $value['variant_name']);
                $spreadsheet->getActiveSheet()->setCellValue('C' . $row, 0);
                $spreadsheet->getActiveSheet()->setCellValue('D' . $row, 0);
                $spreadsheet->getActiveSheet()->setCellValue('E' . $row, 0);
                $spreadsheet->getActiveSheet()->setCellValue('F' . $row, 0);
                $spreadsheet->getActiveSheet()->setCellValue('G' . $row, 0);
                $spreadsheet->getActiveSheet()->setCellValue('H' . $row, 0);
                $spreadsheet->getActiveSheet()->setCellValue('I' . $row, 0);
                $spreadsheet->getActiveSheet()->setCellValue('J' . $row, 0);

                $spreadsheet->getActiveSheet()->setCellValue($occ[$value['occasions_id']] . $row,  $consumer_view);
                $spreadsheet->getActiveSheet()->setCellValue("K" . $row, $value['o1']);
                $spreadsheet->getActiveSheet()->setCellValue("L" . $row, $value['o2']);
                $spreadsheet->getActiveSheet()->setCellValue("M" . $row, $value['o3']);
                $spreadsheet->getActiveSheet()->setCellValue("N" . $row, $value['o4']);
                $spreadsheet->getActiveSheet()->setCellValue("O" . $row, $value['o5']);
            }




            /*********************************sheet5 ***************************************/


            $from_date = $model->from_date;
            $to_date = $model->to_date;
            $start_date = date('Y-m-d H:i:s', strtotime($from_date));
            $end_date = date('Y-m-d 23:59:59', strtotime($to_date));
            $connection = \Yii::$app->db;
            $query = new Query;
            $spreadsheet->createSheet();

            $spreadsheet->setActiveSheetIndex(4);
            $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(18);
            $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(18);
            $spreadsheet->getActiveSheet()->setTitle('User Engagement');
            $spreadsheet->getActiveSheet()->setCellValue('A1', 'Educator');
            $spreadsheet->getActiveSheet()->setCellValue('B1', 'User Random Id');
            $spreadsheet->getActiveSheet()->setCellValue('C1', 'Start Time');
            $spreadsheet->getActiveSheet()->setCellValue('D1', 'End Time');
            $spreadsheet->getActiveSheet()->setCellValue('E1', 'Session Length');
            $data = $connection->createCommand($this->getSheet5Query())
                ->bindValue(':from_date', $start_date)
                ->bindValue(':to_date', $end_date)
                ->queryAll();
            $row = 3;
            $current_cocktail = [];
            $row = 2;
            foreach ($data as $value) {
                $spreadsheet->getActiveSheet()->setCellValue('A' . $row, $value['edu_name']);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $row, $value['user_random_id']);
                $spreadsheet->getActiveSheet()->setCellValue('C' . $row, $value['added_on']);
                $spreadsheet->getActiveSheet()->setCellValue('D' . $row, $value['sub_date']);
                $spreadsheet->getActiveSheet()->setCellValue('E' . $row, $value['session_length']);
                $row++;
            }



            /**********************************sheet5 end***********************************/
            /**********************************sheet6 Start*********************************/


            $from_date = $model->from_date;
            $to_date = $model->to_date;
            $start_date = date('Y-m-d H:i:s', strtotime($from_date));
            $end_date = date('Y-m-d 23:59:59', strtotime($to_date));
            $connection = \Yii::$app->db;
            $query = new Query;
            $spreadsheet->createSheet();

            $spreadsheet->setActiveSheetIndex(5);
            $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(18);
            $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(18);
            $spreadsheet->getActiveSheet()->setTitle('Qr Code Tracking');
            $spreadsheet->getActiveSheet()->setCellValue('A1', 'Pin');
            $spreadsheet->getActiveSheet()->setCellValue('B1', 'Consumer page visit count');
            $spreadsheet->getActiveSheet()->setCellValue('C1', 'Mixing drink page visit count');

            $row = 2;
            $data_row = 2;

            //$SpeedRails = ConsumerClickTrack::find()->all();
            $SpeedRails = $connection->createCommand("SELECT  sum(pt.consumer_page_visit) as consumer_page_count,sum(pt.loading_page_visit) as loading_page_count,pin from pin_qr_track pt
                            WHERE created_at BETWEEN :frm_date
                            AND :to_date GROUP BY pt.pin ORDER BY created_at DESC")
                ->bindValue(':frm_date', $start_date)
                ->bindValue(':to_date', $end_date)
                ->queryAll();
            foreach ($SpeedRails as $val_speedrail) {
                $spreadsheet->getActiveSheet()->setCellValue('A' . $data_row, $val_speedrail['pin']);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $data_row, $val_speedrail['consumer_page_count']);
                $spreadsheet->getActiveSheet()->setCellValue('C' . $data_row, $val_speedrail['loading_page_count']);

                $data_row++;
            }

            /**********************************sheet 6 end**********************************/

            /**********************************sheet7 Start*********************************/


            $from_date = $model->from_date;
            $to_date = $model->to_date;
            $start_date = date('Y-m-d H:i:s', strtotime($from_date));
            $end_date = date('Y-m-d 23:59:59', strtotime($to_date));
            $connection = \Yii::$app->db;
            $query = new Query;
            $spreadsheet->createSheet();

            $spreadsheet->setActiveSheetIndex(6);
            $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(18);
            $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(18);
            $spreadsheet->getActiveSheet()->setTitle('Consumer Page Click Tracking');
            $spreadsheet->getActiveSheet()->setCellValue('A1', 'Pin');
            $spreadsheet->getActiveSheet()->setCellValue('B1', 'Educator');
            $spreadsheet->getActiveSheet()->setCellValue('C1', 'No.of Unique Brand clicks');


            $row = 2;
            $data_row = 2;

            //$SpeedRails = ConsumerClickTrack::find()->all();
            $SpeedRails = $connection->createCommand("SELECT COUNT(ct.speedrail_id) AS click_count,sp.pin,ed.edu_name  FROM  consumer_click_track ct
                        JOIN speedrails sp ON sp.id = ct.speedrail_id
                        JOIN educators ed ON ed.edu_id = sp.edu_id                            
                        where DATE(ct.created_at) >= :frm_date
                        AND DATE(ct.created_at) <= :to_date GROUP BY sp.id ORDER BY ct.created_at DESC")
                ->bindValue(':frm_date', $start_date)
                ->bindValue(':to_date', $end_date)
                ->queryAll();
            foreach ($SpeedRails as $val_speedrail) {
                $spreadsheet->getActiveSheet()->setCellValue('A' . $data_row, $val_speedrail['pin']);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $data_row, $val_speedrail['edu_name']);
                $spreadsheet->getActiveSheet()->setCellValue('C' . $data_row, $val_speedrail['click_count']);
                $data_row++;
            }

            /**********************************sheet 7 end**********************************/

            /**********************************sheet8 Start*********************************/


            $from_date = $model->from_date;
            $to_date = $model->to_date;
            $start_date = date('Y-m-d H:i:s', strtotime($from_date));
            $end_date = date('Y-m-d 23:59:59', strtotime($to_date));
            $connection = \Yii::$app->db;
            $query = new Query;
            $spreadsheet->createSheet();

            $spreadsheet->setActiveSheetIndex(7);
            $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(18);
            $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(18);
            $spreadsheet->getActiveSheet()->setTitle('Email Click Tracking');
            $spreadsheet->getActiveSheet()->setCellValue('A1', 'Pin');
            $spreadsheet->getActiveSheet()->setCellValue('B1', 'Educator');
            $spreadsheet->getActiveSheet()->setCellValue('C1', 'User Random Id');
            $spreadsheet->getActiveSheet()->setCellValue('D1', 'No.of Unique Brand clicks');
            $spreadsheet->getActiveSheet()->setCellValue('E1', '');

            $row = 2;
            $data_row = 2;

            $SpeedRails = $connection->createCommand("SELECT COUNT(ct.id) AS click_count,ct.user_random_id,ed.edu_name, ts.is_pin as pin FROM click_track ct
                    JOIN educators ed ON ed.edu_id = ct.edu_id
                    JOIN trail_submissions ts on ts.user_random_id = ct.user_random_id
                    where DATE(ct.click_date) >= :frm_date
                    AND DATE(ct.click_date) <= :to_date GROUP BY ct.user_random_id ORDER BY ct.click_date DESC")
                ->bindValue(':frm_date', $start_date)
                ->bindValue(':to_date', $end_date)
                ->queryAll();
            foreach ($SpeedRails as $val_speedrail) {
                $spreadsheet->getActiveSheet()->setCellValue('a' . $data_row, $val_speedrail['pin']);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $data_row, $val_speedrail['edu_name']);
                $spreadsheet->getActiveSheet()->setCellValue('C' . $data_row, $val_speedrail['user_random_id']);
                $spreadsheet->getActiveSheet()->setCellValue('D' . $data_row, $val_speedrail['click_count']);
                $data_row++;
            }

            /**********************************sheet 8 end**********************************/


            blank:
            // return $this->render('/site/index', [
            //     'model' => $model,
            // ]);
            excel:
            ob_end_clean();
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            header('Content-Disposition: attachment; filename="Report.xlsx"');
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $writer->save("php://output");
            exit();
        }
        return $this->render('/site/index', [
            'model' => $model,
        ]);
    }

    function createColumnsArray($end_column, $first_letters = '')
    {
        $columns = array();
        $length = strlen($end_column);
        $letters = range('A', 'Z');

        // Iterate over 26 letters.
        foreach ($letters as $letter) {
            // Paste the $first_letters before the next.
            $column = $first_letters . $letter;

            // Add the column to the final array.
            $columns[] = $column;

            // If it was the end column that was added, return the columns.
            if ($column == $end_column)
                return $columns;
        }

        // Add the column children.
        foreach ($columns as $column) {
            // Don't itterate if the $end_column was already set in a previous itteration.
            // Stop iterating if you've reached the maximum character length.
            if (!in_array($end_column, $columns) && strlen($column) < $length) {
                $new_columns = $this->createColumnsArray($end_column, $column);
                // Merge the new columns which were created with the final columns array.
                $columns = array_merge($columns, $new_columns);
            }
        }

        return $columns;
    }

    public function sumofdatediff($times)
    {
        $data = 0;

        if (!empty($times)) {
            $first = $times[0];
            array_shift($times);

            foreach ($times as $time) {
                //p($time);
                $secs = strtotime($time) - strtotime("05:30:00");
                //p($secs);
                //echo date('s', $secs);
                //exit;


                $data = $data + $secs;
            }
            $data = abs($data / 60);

            $session_time = date("H:i:s", strtotime($first) + $data);
            $time_array = explode(':', $session_time);
            $final_time = $time_array[0]  + $time_array[1] . ":" . $time_array[2];

            return $final_time;
        } else {
            return '00:00';
        }
    }


    public function actionReporting()
    {
        $this->layout = 'main_new';
        return $this->render('reporting');
    }

    public function actionReportingCalendar()
    {
        $this->layout = 'main_new';
        return $this->render('reporting-calendar');
    }
    public function getSheet1Query()
    {

        return $query = "SELECT e.city, e.edu_name, e.edu_id, pt.consumers_engaged, mt.mrque_count AS 'marque_count', ct.cocktail_count AS 'cocktail_count', COUNT(DISTINCT (email.user_random_id)) AS 'email_delivery', ts.session_length 'session_length', COUNT(DISTINCT (mail.user_random_id)) AS 'email_opened', COUNT(DISTINCT (click.user_random_id)) AS 'email_click', sp.cnt AS 'pin_generated' FROM educators e LEFT JOIN ( SELECT COUNT(DISTINCT (pt.user_random_id)) AS 'consumers_engaged', edu_id FROM pro_track AS pt WHERE ( pt.added_on BETWEEN :from_date AND :to_date ) GROUP BY edu_id) AS pt ON pt.edu_id=e.edu_id LEFT JOIN (SELECT COUNT(DISTINCT pt.user_random_id) AS mrque_count, pt.edu_id, pt.user_random_id FROM pro_track AS pt INNER JOIN marques AS m ON pt.marque_id = m.id AND ( pt.added_on BETWEEN :from_date AND :to_date ) GROUP BY pt.edu_id) AS mt ON mt.edu_id = e.edu_id LEFT JOIN (SELECT COUNT(DISTINCT user_random_id) AS cocktail_count, t.edu_id, user_random_id FROM pro_track t INNER JOIN cocktail p ON t.cocktail_id = p.id WHERE t.event_typ = 'product_add_trail' AND ( added_on BETWEEN :from_date AND :to_date ) GROUP BY t.edu_id) AS ct ON ct.edu_id = e.edu_id LEFT JOIN (SELECT SEC_TO_TIME(SUM(ts.sl)) AS session_length, ts.edu_id FROM (SELECT TIMESTAMPDIFF(SECOND, pt.added_on, tl.sub_date) AS sl, pt.edu_id FROM pro_track pt INNER JOIN trail_submissions tl ON tl.user_random_id = pt.user_random_id AND pt.edu_id=tl.edu_id WHERE pt.added_on BETWEEN :from_date AND :to_date GROUP BY pt.user_random_id, pt.edu_id DESC) AS ts GROUP BY ts.edu_id) AS ts ON ts.edu_id = e.edu_id LEFT JOIN trail_submissions AS email ON email.edu_id = e.edu_id AND ( req_time BETWEEN :from_date AND :to_date ) AND sub_id IS NOT NULL LEFT JOIN mail_track AS mail ON mail.edu_id=e.edu_id AND ( mail.open_date BETWEEN :from_date AND :to_date ) LEFT JOIN click_track AS click ON click.edu_id=e.edu_id AND ( click.click_date BETWEEN :from_date AND :to_date ) LEFT JOIN (SELECT COUNT(id) AS cnt,edu_id FROM speedrails GROUP BY edu_id) AS sp ON sp.edu_id=e.edu_id GROUP BY e.city, e.edu_id ORDER BY e.city, e.edu_name";
    }
    public function getSheet2Query()
    {
        return "SELECT e.edu_id, e.edu_name, pt.cs AS consumers_engaged, c.id AS occasion_id FROM educators AS e LEFT JOIN occasions_v3 AS c ON 1=1 LEFT JOIN (SELECT COUNT(DISTINCT (pt.user_random_id)) AS cs, pt.edu_id, pt.occ_id FROM pro_track AS pt INNER JOIN occasions_v3 AS c ON pt.occ_id = c.id AND ( pt.added_on BETWEEN :from_date AND :to_date ) GROUP BY pt.edu_id, pt.occ_id) AS pt ON pt.edu_id = e.edu_id AND c.id = pt.occ_id GROUP BY c.id, e.edu_id, pt.occ_id ORDER BY e.edu_name, e.edu_id, pt.occ_id
      
      ";
    }
    public function getSheet3Query()
    {
        return "SELECT brand_details.id AS brand_id, brand_details.brand_name, marques.id AS marque_id, marques.name AS variant_name, moments_v3.id AS moment_id, moments_v3.name, occasions_v3.id AS occasion_id, occasions_v3.name AS occasions_name, cs.cs AS consumer_view, ( CASE WHEN sp.order_no = 1 THEN sp.cnt ELSE 0 END ) AS o1, ( CASE WHEN sp.order_no = 2 THEN sp.cnt ELSE 0 END ) AS o2, ( CASE WHEN sp.order_no = 3 THEN sp.cnt ELSE 0 END ) AS o3, ( CASE WHEN sp.order_no = 4 THEN sp.cnt ELSE 0 END ) AS o4, ( CASE WHEN sp.order_no = 5 THEN sp.cnt ELSE 0 END ) AS o5 FROM marques LEFT JOIN (SELECT COUNT(id) AS cnt, marque_id, order_no FROM submission_products WHERE ( sub_date BETWEEN :from_date AND :to_date ) AND marque_id IS NOT NULL GROUP BY marque_id, order_no) AS sp ON sp.marque_id = marques.id INNER JOIN brand_details ON marques.brand_id = brand_details.id INNER JOIN marques_occasion ON marques_occasion.marques_id = marques.id INNER JOIN occasions_v3 ON occasions_v3.id = marques_occasion.occasion_id INNER JOIN moments_v3 ON occasions_v3.moment_id = moments_v3.id LEFT JOIN (SELECT COUNT(DISTINCT (pt.user_random_id)) AS cs, pt.marque_id, pt.occ_id, pt.mom_id FROM pro_track pt WHERE pt.event_typ = 'product_view' AND ( pt.added_on BETWEEN :from_date AND :to_date ) AND pt.marque_id IS NOT NULL GROUP BY pt.marque_id, pt.occ_id, pt.mom_id) AS cs ON moments_v3.id = cs.mom_id AND occasions_v3.id = cs.occ_id AND marques.id = cs.marque_id GROUP BY brand_details.id, marques.id, moments_v3.id, occasions_v3.id ORDER BY brand_details.brand_name, marques.name,marques.id, moments_v3.id,occasions_v3.id";
    }
    public function getSheet4Query()
    {
        return "SELECT brand_details.id AS brand_id, brand_details.brand_name, marques.id AS marque_id, marques.name AS marque_name, occasions_v3.id AS occasions_id, occasions_v3.name AS occasions_name, cocktail.id AS cocktail_id, cocktail.name AS variant_name, cs.cs AS consumer_view, ( CASE WHEN sp.order_no = 1 THEN sp.cnt ELSE 0 END ) AS o1, ( CASE WHEN sp.order_no = 2 THEN sp.cnt ELSE 0 END ) AS o2, ( CASE WHEN sp.order_no = 3 THEN sp.cnt ELSE 0 END ) AS o3, ( CASE WHEN sp.order_no = 4 THEN sp.cnt ELSE 0 END ) AS o4, ( CASE WHEN sp.order_no = 5 THEN sp.cnt ELSE 0 END ) AS o5 FROM cocktail LEFT JOIN (SELECT COUNT(id) AS cnt, cocktail_id, order_no FROM submission_products WHERE ( sub_date BETWEEN :from_date AND :to_date ) AND cocktail_id IS NOT NULL GROUP BY cocktail_id, order_no) AS sp ON sp.cocktail_id=cocktail.id INNER JOIN marques ON marques.id = cocktail.marque_id INNER JOIN brand_details ON marques.brand_id = brand_details.id INNER JOIN marques_occasion ON marques_occasion.marques_id = marques.id INNER JOIN occasions_v3 ON occasions_v3.id = marques_occasion.occasion_id LEFT JOIN ( SELECT COUNT(DISTINCT (pt.user_random_id)) AS cs, pt.occ_id, pt.cocktail_id FROM pro_track AS pt WHERE pt.event_typ = 'product_view' AND ( pt.added_on BETWEEN :from_date AND :to_date ) AND pt.cocktail_id IS NOT NULL GROUP BY pt.occ_id, pt.cocktail_id) AS cs ON cs.cocktail_id=cocktail.id AND occasions_v3.id=cs.occ_id ORDER BY brand_details.brand_name, cocktail.name, occasions_v3.id, occasions_v3.name";
    }
    public function getSheet5Query()
    {
        return "SELECT pt.event_typ, pt.user_random_id, pt.edu_id, e.edu_name, pt.added_on, ts.sub_date, SEC_TO_TIME(TIMESTAMPDIFF(SECOND, pt.added_on, ts.sub_date)) AS session_length FROM pro_track pt INNER JOIN educators AS e ON e.edu_id=pt.edu_id LEFT JOIN trail_submissions AS ts ON ts.user_random_id = pt.user_random_id AND ts.edu_id=pt.edu_id WHERE ( pt.added_on BETWEEN :from_date AND :to_date ) GROUP BY pt.user_random_id ORDER BY pt.added_on,e.edu_name";
    }
}
