<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ReportForm;
//use Yii;
use app\models\Educators;
use app\models\ProTrack;
use app\models\SubmissionProducts;
use app\models\Occasions;
use app\models\EduPiiCount;
use app\models\Moments;
use app\models\User;
use app\models\BackendOtpDetails;
use app\models\MailTrack;
use app\models\ClickTrack;
use app\models\OtpForm;
use app\models\Market;
use yii\db\Query;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Session;
use yii\helpers\Html;
use app\models\TrailSubmissions;

class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => 'error',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */

    public function actionIndex() {
//        echo date("H:i:s", 60).'<br>';die;
//        return $this->render('index');
        $model = new ReportForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            /*             * ************************************************** Sheet One ************************************ */
            $from_date = $model->from_date;
            $to_date = $model->to_date;
            $start_date = date('Y-m-d H:i:s', strtotime($from_date));
            $end_date = date('Y-m-d', strtotime($to_date)) . ' 23:59:59';
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
            $spreadsheet->getActiveSheet()->setCellValue('G1', 'Session Length (hh:mm:ss)');
            $spreadsheet->getActiveSheet()->setCellValue('H1', 'Consumers who opened the email');
            $spreadsheet->getActiveSheet()->setCellValue('I1', '# of click-thrus from the email');
            $City = Educators::find()->select('city')->distinct()->all(); // select all city
            $row = 2;
            $data_row = 3;
            foreach ($City as $val_city) {
                $market = Market::find()->where(['id'=>$val_city->city])->one();
                $market_name = isset($market->name)?$market->name:'-';
                $spreadsheet->getActiveSheet()->setCellValue('A' . $row, $market_name);  // print city
                $Educator = Educators::find()->where(['city' => $val_city->city])->all(); // select all educator in a city
                foreach ($Educator as $val_educator) {
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $data_row, $val_educator->edu_name); // print educator name
                    $cons_engaged = ProTrack::find()->where(['edu_id' => $val_educator->edu_id])->andWhere(['between', 'added_on', $start_date, $end_date])->count('DISTINCT(user_random_id)'); // select consumers engaged by educator
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $data_row, $cons_engaged); // print educator name
                    $marque_speed_rail_added = $connection->createCommand("select count(distinct user_random_id) as mrque_count from pro_track t inner join products p on t.pro_id=p.pro_id 
where t.edu_id=:edu and t.event_typ=:typ  and p.pro_type=:pro_typ 
and (added_on BETWEEN :frm_date and :to_date)")
                            ->bindValue(':edu', $val_educator->edu_id)
                            ->bindValue(':typ', 'product_add_trail')
                            ->bindValue(':pro_typ', 'marque')
                            ->bindValue(':frm_date', $start_date)
                            ->bindValue(':to_date', $end_date)
                            ->queryOne();
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $data_row, $marque_speed_rail_added['mrque_count']); // print marque added on speed rail count by educator
                    $cocktail_speed_rail_added = $connection->createCommand("select count( distinct user_random_id) as cocktail_count from pro_track t inner join products p on t.pro_id=p.pro_id 
where t.edu_id=:edu and t.event_typ=:typ  and p.pro_type=:pro_typ 
and (added_on BETWEEN :frm_date and :to_date)")
                            ->bindValue(':edu', $val_educator->edu_id)
                            ->bindValue(':typ', 'product_add_trail')
                            ->bindValue(':pro_typ', 'cocktail')
                            ->bindValue(':frm_date', $start_date)
                            ->bindValue(':to_date', $end_date)
                            ->queryOne();
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $data_row, $cocktail_speed_rail_added['cocktail_count']); // print marque added on speed rail count by educator
                    $cons_submited = EduPiiCount::find()->where(['edu_id' => $val_educator->edu_id])->andWhere(['between', 'req_time', $start_date, $end_date])->sum('req_count');
                    $cons_submited = isset($cons_submited) ? $cons_submited : 0;
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $data_row, $cons_submited); // print count of consumers prefer to sumit by educator
                    $trail_users = \app\models\TrailSubmissions::find()->where(['edu_id' => $val_educator->edu_id])->andWhere(['between', 'sub_date', $start_date, $end_date])->select('distinct (user_random_id)')->all();
                    $length = 0;
                    $avg_session_length = 0;
                    foreach ($trail_users as $value) {
                        $trails = \app\models\TrailSubmissions::find()->where(['user_random_id' => $value['user_random_id']])->one();
                        $random_string = explode("_", $value['user_random_id']);
            $dateval = str_replace("T", " ", $random_string[1]);
            #echo $dateval; exit;
                        $session_start_time = ProTrack::find()->select('added_on')->where(['user_random_id' => $value['user_random_id'], 'event_typ' => 'moment_view'])->one();
                        $session_start = ($session_start_time != null)?strtotime($session_start_time->added_on):0;
                        $session_length = strtotime($trails['sub_date']) - $session_start; // in seconds
                        $length =  $length + $session_length;
                    }
                    if ($cons_engaged != 0) {
                        $avg_session_length = $length / $cons_engaged;
                    }
                    $final_session_lenth = ($avg_session_length != 0 ) ? $this->avgsession($avg_session_length) : '00:00:00';
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $data_row, $final_session_lenth); // print total session length by educator
                    $Mail_track_count = MailTrack::find()->where(['edu_id' => $val_educator->edu_id])->andWhere(['between', 'open_date', $start_date, $end_date])->count();
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $data_row, $Mail_track_count); // print total count of consumers opend mail by educator
                    $Mail_track_count = ClickTrack::find()->where(['edu_id' => $val_educator->edu_id])->andWhere(['between', 'click_date', $start_date, $end_date])->count();
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $data_row, $Mail_track_count); // print total count of consumers opend mail by educator
                    $data_row++;
                }
                $data_row++;
                $row = $row + 1 + count($Educator);
            }
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

            $query->select(['moments.mom_id', 'moments.mom_name'])
                    ->from('moments');
            $command = $query->createCommand();
            $data = $command->queryAll(); // select all moments
            $stack = array();
            $allEducators = array();
            array_push($allEducators, 'All Educators');
            foreach ($data as $value) {
                $moment = $value['mom_name'];
                $query->select(['occasions.occ_id', 'occasions.occ_name'])
                        ->from('occasions')
                        ->where('occasions.mom_id = :id', [':id' => $value['mom_id']]);
                $command = $query->createCommand();
                $data_occ = $command->queryAll();  // select occasions with moments
                foreach ($data_occ as $value_occ) {
                    array_push($stack, $value_occ['occ_name']);
                    $row_occ_count = ProTrack::find()->where(['occ_id' => $value_occ['occ_id'], 'event_typ' => 'occ_view'])->andWhere(['between', 'added_on', $start_date, $end_date])->count();
                    array_push($allEducators, $row_occ_count);
                }
            }
            $count_stack = count($stack);

            $count_col = count($allEducators);
            $rangeArray = $this->createColumnsArray('ZZ');
            $range = array_splice($rangeArray, 0, $count_col);
            $_row = 0;
            foreach ($range as $val_array) {
                $spreadsheet->getActiveSheet()->setCellValue($val_array . '4', $allEducators[$_row]); // print row for All Educators
                $_row++;
            }
            $row_educators = Educators::find()->all();
            $Educator = [];
            foreach ($row_educators as $val_educators) {
                $row_momets = Moments::find()->all();
                $oc_array = [];
                $oc_array['name'] = $val_educators['edu_name'];
                foreach ($row_momets as $val_momets) {
                    $row_occasion = Occasions::find()->where(['mom_id' => $val_momets['mom_id']])->all();
                    foreach ($row_occasion as $val_occasion) {
                        $row_occ_count = ProTrack::find()->where(['occ_id' => $val_occasion['occ_id'], 'edu_id' => $val_educators['edu_id'], 'event_typ' => 'occ_view'])->andWhere(['between', 'added_on', $start_date, $end_date])->count();
                        $oc_array[$val_occasion['occ_name']] = $row_occ_count;
                    }
                }
                $Educator[$val_educators['edu_name']] = $oc_array;
            }
            $column = 5;
            foreach ($Educator as $edu_name => $edu_data) {
                $rangeArray = $this->createColumnsArray('ZZ');
                $moment_count = count($edu_data);
                $range = array_splice($rangeArray, 0, $moment_count);
                foreach ($edu_data as $moment_key => $count) {
                    $index = array_search($moment_key, array_keys($edu_data));
                    $position = $range[$index];
                    $spreadsheet->getActiveSheet()->setCellValue($position . $column, $count); // print all records group by educators
                }
                $column++;
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
            $spreadsheet->getActiveSheet()->mergeCells("K1:R1");
            $spreadsheet->getActiveSheet()->setCellValue('K1', 'Consumers that added it to Speed Rail from:');
            $spreadsheet->getActiveSheet()->mergeCells("S1:W1");
            $spreadsheet->getActiveSheet()->setCellValue('S1', 'Consumers that added it to Speed Rail by Order:');
            $spreadsheet->getActiveSheet()->mergeCells("C2:D2");
            $spreadsheet->getActiveSheet()->setCellValue('C2', 'Familiar Moments (FM)');
            $spreadsheet->getActiveSheet()->mergeCells("E2:F2");
            $spreadsheet->getActiveSheet()->setCellValue('E2', 'Moments Worth Enhancing (MWE)');
            $spreadsheet->getActiveSheet()->mergeCells("G2:H2");
            $spreadsheet->getActiveSheet()->setCellValue('G2', 'Moments To Connect (MtC)');
            $spreadsheet->getActiveSheet()->mergeCells("I2:J2");
            $spreadsheet->getActiveSheet()->setCellValue('I2', 'Upbeat Moments (UM)');
            $spreadsheet->getActiveSheet()->mergeCells("K2:L2");
            $spreadsheet->getActiveSheet()->setCellValue('K2', 'Familiar Moments (FM)');
            $spreadsheet->getActiveSheet()->mergeCells("M2:N2");
            $spreadsheet->getActiveSheet()->setCellValue('M2', 'Moments Worth Enhancing (MWE)');
            $spreadsheet->getActiveSheet()->mergeCells("O2:P2");
            $spreadsheet->getActiveSheet()->setCellValue('O2', 'Moments To Connect (MtC)');
            $spreadsheet->getActiveSheet()->mergeCells("Q2:R2");
            $spreadsheet->getActiveSheet()->setCellValue('Q2', 'Moments To Connect (MtC)');
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
            $spreadsheet->getActiveSheet()->setCellValue('K3', 'Everyday evening at home');
            $spreadsheet->getActiveSheet()->setCellValue('L3', 'Fun relaxing evening at home');
            $spreadsheet->getActiveSheet()->setCellValue('M3', 'Indulgent moment at home');
            $spreadsheet->getActiveSheet()->setCellValue('N3', 'Planned Special Meal');
            $spreadsheet->getActiveSheet()->setCellValue('O3', 'Easygoing Hangout at home');
            $spreadsheet->getActiveSheet()->setCellValue('P3', 'Family meal together');
            $spreadsheet->getActiveSheet()->setCellValue('Q3', 'High energy hangout at home');
            $spreadsheet->getActiveSheet()->setCellValue('R3', 'Fun meal at home');
            $spreadsheet->getActiveSheet()->mergeCells("S2:S3");
            $spreadsheet->getActiveSheet()->setCellValue('S2', '1');
            $spreadsheet->getActiveSheet()->mergeCells("T2:T3");
            $spreadsheet->getActiveSheet()->setCellValue('T2', '2');
            $spreadsheet->getActiveSheet()->mergeCells("U2:U3");
            $spreadsheet->getActiveSheet()->setCellValue('U2', '3');
            $spreadsheet->getActiveSheet()->mergeCells("V2:V3");
            $spreadsheet->getActiveSheet()->setCellValue('V2', '4');
            $spreadsheet->getActiveSheet()->mergeCells("W2:W3");
            $spreadsheet->getActiveSheet()->setCellValue('W2', '5');
            $Brands = \app\models\Brands::find()->all();
            $Brand_Array = [];
            $row_array = [];
            foreach ($Brands as $val_brand) {// find all brands
                $Varient = \app\models\Products::find()->where(['brand_id' => $val_brand['brand_id'], 'pro_type' => 'marque'])->all();

                foreach ($Varient as $val_varient) {// find all products with brand id
                    $row_momets = Moments::find()->all();
                    $row_array['brand_name'] = $val_brand['brand_name'];
                    $row_array['variant_name'] = $val_varient['pro_name'];
                    $occ_list = \app\models\Pmo::find()->where(['pro_id' => $val_varient['pro_id']])->all();
                    $listData = ArrayHelper::map($occ_list, 'pmo_id', 'occ_id');
                    //****************************** Consumers that viewed it on: *****************************
                    foreach ($row_momets as $val_momets) {
                        $row_occasion = Occasions::find()->where(['mom_id' => $val_momets['mom_id']])->all();
                        foreach ($row_occasion as $val_occasion) {
                            if (in_array($val_occasion['occ_id'], $listData)) {
                                $row_occ_count = ProTrack::find()->where(['occ_id' => $val_occasion['occ_id'], 'event_typ' => 'occ_view_marques'])->andWhere(['between', 'added_on', $start_date, $end_date])->count('DISTINCT(user_random_id)');
                                $row_array[$val_occasion['occ_name']] = $row_occ_count;
                            } else {
                                $row_array[$val_occasion['occ_name']] = 0;
                            }
                        }
                    }
                    //****************************** Consumers that added it to Speed Rail from: *****************************
                    foreach ($row_momets as $val_momets) {
                        $row_occasion = Occasions::find()->where(['mom_id' => $val_momets['mom_id']])->all();
                        foreach ($row_occasion as $val_occasion) {
                            $row_occ_count = ProTrack::find()->where(['occ_id' => $val_occasion['occ_id'], 'pro_id' => $val_varient['pro_id'], 'event_typ' => 'product_add_trail'])->andWhere(['between', 'added_on', $start_date, $end_date])->count();
                            $row_array[$val_occasion['occ_name'] . '1'] = $row_occ_count;
                        }
                    }
                    array_push($Brand_Array, $row_array);
                }
            }
            $col = 4;
            foreach ($Brand_Array as $val_brand) {
                $rangeArray = $this->createColumnsArray('ZZ');
                $col_count = count($val_brand);
                $range = array_splice($rangeArray, 0, $col_count);
                foreach ($val_brand as $val_key => $data) {
                    $index = array_search($val_key, array_keys($val_brand));
                    $position = $range[$index];
                    $spreadsheet->getActiveSheet()->setCellValue($position . $col, $data); // print all records group by educators
                }
                $col++;
            }
            $oder_Array = [];
            $pos_array = [];
            foreach ($Brands as $val_brand) {// find all brands
                $Varient = \app\models\Products::find()->where(['brand_id' => $val_brand['brand_id'], 'pro_type' => 'marque'])->all();
                foreach ($Varient as $val_varient) { // find all products
                    $pos_array['Pos1'] = SubmissionProducts::find()->where(['prod_id' => $val_varient['pro_id'], 'order_no' => 1])->andWhere(['between', 'sub_date', $start_date, $end_date])->count();
                    $pos_array['Pos2'] = SubmissionProducts::find()->where(['prod_id' => $val_varient['pro_id'], 'order_no' => 2])->andWhere(['between', 'sub_date', $start_date, $end_date])->count();
                    $pos_array['Pos3'] = SubmissionProducts::find()->where(['prod_id' => $val_varient['pro_id'], 'order_no' => 3])->andWhere(['between', 'sub_date', $start_date, $end_date])->count();
                    $pos_array['Pos4'] = SubmissionProducts::find()->where(['prod_id' => $val_varient['pro_id'], 'order_no' => 4])->andWhere(['between', 'sub_date', $start_date, $end_date])->count();
                    $pos_array['Pos5'] = SubmissionProducts::find()->where(['prod_id' => $val_varient['pro_id'], 'order_no' => 5])->andWhere(['between', 'sub_date', $start_date, $end_date])->count();
                    array_push($oder_Array, $pos_array);
                }
            }
            $col = 4;
            foreach ($oder_Array as $val_order) {
                $spreadsheet->getActiveSheet()->setCellValue('S' . $col, $val_order['Pos1']);
                $spreadsheet->getActiveSheet()->setCellValue('T' . $col, $val_order['Pos2']);
                $spreadsheet->getActiveSheet()->setCellValue('U' . $col, $val_order['Pos3']);
                $spreadsheet->getActiveSheet()->setCellValue('v' . $col, $val_order['Pos4']);
                $spreadsheet->getActiveSheet()->setCellValue('W' . $col, $val_order['Pos5']);
                $col++;
            }
            /**             * ************************************************* Sheet Four ************************************ */
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
            $spreadsheet->getActiveSheet()->mergeCells("K1:R1");
            $spreadsheet->getActiveSheet()->setCellValue('K1', 'Consumers that added it to Speed Rail from:');
            $spreadsheet->getActiveSheet()->mergeCells("S1:W1");
            $spreadsheet->getActiveSheet()->setCellValue('S1', 'Consumers that added it to Speed Rail by Order:');
            $spreadsheet->getActiveSheet()->mergeCells("C2:D2");
            $spreadsheet->getActiveSheet()->setCellValue('C2', 'Familiar Moments (FM)');
            $spreadsheet->getActiveSheet()->mergeCells("E2:F2");
            $spreadsheet->getActiveSheet()->setCellValue('E2', 'Moments Worth Enhancing (MWE)');
            $spreadsheet->getActiveSheet()->mergeCells("G2:H2");
            $spreadsheet->getActiveSheet()->setCellValue('G2', 'Moments To Connect (MtC)');
            $spreadsheet->getActiveSheet()->mergeCells("I2:J2");
            $spreadsheet->getActiveSheet()->setCellValue('I2', 'Upbeat Moments (UM)');
            $spreadsheet->getActiveSheet()->mergeCells("K2:L2");
            $spreadsheet->getActiveSheet()->setCellValue('K2', 'Familiar Moments (FM)');
            $spreadsheet->getActiveSheet()->mergeCells("M2:N2");
            $spreadsheet->getActiveSheet()->setCellValue('M2', 'Moments Worth Enhancing (MWE)');
            $spreadsheet->getActiveSheet()->mergeCells("O2:P2");
            $spreadsheet->getActiveSheet()->setCellValue('O2', 'Moments To Connect (MtC)');
            $spreadsheet->getActiveSheet()->mergeCells("Q2:R2");
            $spreadsheet->getActiveSheet()->setCellValue('Q2', 'Moments To Connect (MtC)');
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
            $spreadsheet->getActiveSheet()->setCellValue('K3', 'Everyday evening at home');
            $spreadsheet->getActiveSheet()->setCellValue('L3', 'Fun relaxing evening at home');
            $spreadsheet->getActiveSheet()->setCellValue('M3', 'Indulgent moment at home');
            $spreadsheet->getActiveSheet()->setCellValue('N3', 'Planned Special Meal');
            $spreadsheet->getActiveSheet()->setCellValue('O3', 'Easygoing Hangout at home');
            $spreadsheet->getActiveSheet()->setCellValue('P3', 'Family meal together');
            $spreadsheet->getActiveSheet()->setCellValue('Q3', 'High energy hangout at home');
            $spreadsheet->getActiveSheet()->setCellValue('R3', 'Fun meal at home');
            $spreadsheet->getActiveSheet()->mergeCells("S2:S3");
            $spreadsheet->getActiveSheet()->setCellValue('S2', '1');
            $spreadsheet->getActiveSheet()->mergeCells("T2:T3");
            $spreadsheet->getActiveSheet()->setCellValue('T2', '2');
            $spreadsheet->getActiveSheet()->mergeCells("U2:U3");
            $spreadsheet->getActiveSheet()->setCellValue('U2', '3');
            $spreadsheet->getActiveSheet()->mergeCells("V2:V3");
            $spreadsheet->getActiveSheet()->setCellValue('V2', '4');
            $spreadsheet->getActiveSheet()->mergeCells("W2:W3");
            $spreadsheet->getActiveSheet()->setCellValue('W2', '5');



            $Brands = \app\models\Brands::find()->all();
            $Brand_Array = [];
            $row_array = [];
            foreach ($Brands as $val_brand) {// find all brands
                $Varient = \app\models\Products::find()->where(['brand_id' => $val_brand['brand_id'], 'pro_type' => 'cocktail'])->all();
                foreach ($Varient as $val_varient) {// find all products with brand id
                    $row_momets = Moments::find()->all();
                    $row_array['brand_name'] = $val_brand['brand_name'];
                    $row_array['variant_name'] = $val_varient['pro_name'] . ' - ' . $val_varient['sub_name']; // pro name appended with sub name
                    //****************************** Consumers that viewed it on: *****************************
                    $occ_list = \app\models\Pmo::find()->where(['pro_id' => $val_varient['pro_id']])->all();
                    $listData = ArrayHelper::map($occ_list, 'pmo_id', 'occ_id');
                    foreach ($row_momets as $val_momets) {
                        $row_occasion = Occasions::find()->where(['mom_id' => $val_momets['mom_id']])->all();
                        foreach ($row_occasion as $val_occasion) {
                            if (in_array($val_occasion['occ_id'], $listData)) {
                                $row_occ_count = ProTrack::find()->where(['occ_id' => $val_occasion['occ_id'], 'event_typ' => 'occ_view_cocktails'])->andWhere(['between', 'added_on', $start_date, $end_date])->count('DISTINCT(user_random_id)');
                                $row_array[$val_occasion['occ_name']] = $row_occ_count;
                            } else {
                                $row_array[$val_occasion['occ_name']] = 0;
                            }
                        }
                    }
                    //****************************** Consumers that added it to Speed Rail from: *****************************
                    foreach ($row_momets as $val_momets) {
                        $row_occasion = Occasions::find()->where(['mom_id' => $val_momets['mom_id']])->all();
                        foreach ($row_occasion as $val_occasion) {
                            $row_occ_count = ProTrack::find()->where(['occ_id' => $val_occasion['occ_id'], 'pro_id' => $val_varient['pro_id'], 'event_typ' => 'product_add_trail'])->andWhere(['between', 'added_on', $start_date, $end_date])->count();
                            $row_array[$val_occasion['occ_name'] . '1'] = $row_occ_count;
                        }
                    }
                    array_push($Brand_Array, $row_array);
                }
            }
            $col = 4;
            foreach ($Brand_Array as $val_brand) {
                $rangeArray = $this->createColumnsArray('ZZ');
                $col_count = count($val_brand);
                $range = array_splice($rangeArray, 0, $col_count);
                foreach ($val_brand as $val_key => $data) {
                    $index = array_search($val_key, array_keys($val_brand));
                    $position = $range[$index];
                    $spreadsheet->getActiveSheet()->setCellValue($position . $col, $data); // print all records group by educators
                }
                $col++;
            }
            $oder_Array = [];
            $pos_array = [];
            foreach ($Brands as $val_brand) {// find all brands
                $Varient = \app\models\Products::find()->where(['brand_id' => $val_brand['brand_id'], 'pro_type' => 'cocktail'])->all();
                foreach ($Varient as $val_varient) { // find all products
                    $pos_array['Pos1'] = SubmissionProducts::find()->where(['prod_id' => $val_varient['pro_id'], 'order_no' => 1])->andWhere(['between', 'sub_date', $start_date, $end_date])->count();
                    $pos_array['Pos2'] = SubmissionProducts::find()->where(['prod_id' => $val_varient['pro_id'], 'order_no' => 2])->andWhere(['between', 'sub_date', $start_date, $end_date])->count();
                    $pos_array['Pos3'] = SubmissionProducts::find()->where(['prod_id' => $val_varient['pro_id'], 'order_no' => 3])->andWhere(['between', 'sub_date', $start_date, $end_date])->count();
                    $pos_array['Pos4'] = SubmissionProducts::find()->where(['prod_id' => $val_varient['pro_id'], 'order_no' => 4])->andWhere(['between', 'sub_date', $start_date, $end_date])->count();
                    $pos_array['Pos5'] = SubmissionProducts::find()->where(['prod_id' => $val_varient['pro_id'], 'order_no' => 5])->andWhere(['between', 'sub_date', $start_date, $end_date])->count();
                    array_push($oder_Array, $pos_array);
                }
            }
            $col = 4;
            foreach ($oder_Array as $val_order) {
                $spreadsheet->getActiveSheet()->setCellValue('S' . $col, $val_order['Pos1']);
                $spreadsheet->getActiveSheet()->setCellValue('T' . $col, $val_order['Pos2']);
                $spreadsheet->getActiveSheet()->setCellValue('U' . $col, $val_order['Pos3']);
                $spreadsheet->getActiveSheet()->setCellValue('v' . $col, $val_order['Pos4']);
                $spreadsheet->getActiveSheet()->setCellValue('W' . $col, $val_order['Pos5']);
                $col++;
            }
            $spreadsheet->setActiveSheetIndex(0);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            header('Content-Disposition: attachment; filename="Report.xlsx"');
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $writer->save("php://output");
            exit();
        }
        $version = '2.0';
        // return $this->render('/coc/index', [
        //             'model' => $model, 'version'=>$version
        // ]);
        return $this->redirect(['cocktail/index']);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            $user_model = User::find()->select('id,email')->where(['username' => $model->username])->one();
            Yii::$app->user->login($user_model);
            return $this->redirect(['cocktail/index']);
        }

        $model->password = '';
        $version = '2.0';
        return $this->render('login', [
            'model' => $model, 'version'=>$version
        ]);
    }

    public function actionOtpverification() {
        $this->layout = 'login';
        $model = new OtpForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $otp_model = BackendOtpDetails::find()->where(['key' => $_REQUEST['key']])->one();
            $user_model = User::find()->where(['id' => $otp_model->user_id])->one();

            Yii::$app->user->login($user_model, ($_REQUEST['remember'] == 1) ? 3600 * 24 * 30 : 0);
            return $this->redirect(['cocktail/index']);
        }
        return $this->render('otpverification', [
                    'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();
        $reloginUrl = "https://dxc.mktg.run/";
        return $this->redirect($reloginUrl);
        //return $this->redirect(['login']);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                    'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() {
        return $this->render('about');
    }

    public function actionTest() {
        $this->layout = "main_new";
        return $this->render('test');
    }

    function createColumnsArray($end_column, $first_letters = '') {
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

    public function sumofdatediff($times) {
        $data = 0;
        if (!empty($times)) {
            $first = $times[0];
            array_shift($times);
            foreach ($times as $time) {
                $secs = strtotime($time) - strtotime("00:00:00");
                $data = $data + $secs;
            }
            $session_time = date("H:i:s", strtotime($first) + $data);
            $time_array = explode(':', $session_time);
            $final_time = $time_array[0] * 60 + $time_array[1] . ":" . $time_array[2];
            return $final_time;
        } else {
            return '00:00';
        }
    }

    //fmdb dashboard
    public function actionFmdb(){

        $session = Yii::$app->session;
        if ($session->has('fmdb_user') && $session->get('fmdb_user')=='success'){
            echo '1. '.Html::a('Upload File', ['site/upload']).'<br><br>';
            echo '2. '.Html::a('Export Edcators Table', ['site/export', 'id'=>1]).'<br><br>';
            echo '3. '.Html::a('Export Pro Track Table', ['site/export', 'id'=>2]).'<br><br>';
            echo '4. '.Html::a('Export Trail Submissions Table', ['site/export', 'id'=>3]).'<br><br>';
            
            $url = Url::toRoute('site/fmdb-login');
            echo '<form action='.$url.' method="post">
            <input type="hidden" name="logout" id="logout" value="1">
            <input type="hidden" name="'.Yii::$app->request->csrfParam.'" value="'. Yii::$app->request->csrfToken.'" />
            <input type="submit" value="Logout" name="submit">
            </form>';
        }else{
            $url = Url::toRoute('site/fmdb-login');
            echo '<form action='.$url.' method="post" enctype="multipart/form-data">
            FMDB LOGIN:<br><br>
            Username : <input type="text" name="fmdb_username" id="fmdb_username"><br><br>
            Password : <input type="password" name="fmdb_password" id="fmdb_password"><br><br>
            <input type="hidden" name="login" id="fmdb_login" value="1">
            <input type="hidden" name="'.Yii::$app->request->csrfParam.'" value="'. Yii::$app->request->csrfToken.'" />
            <input type="submit" value="Submit" name="submit">
            </form>';
            //echo '<a href="'.Url::to(['site/fmdb']).'">Back</a>';
        }
    }

    //fmdb login/logout
    public function actionFmdbLogin(){

        $session = Yii::$app->session;
        if(Yii::$app->request->post('login') && Yii::$app->request->post('login')!=null){ 
            $username = Yii::$app->request->post('fmdb_username');
            $password = Yii::$app->request->post('fmdb_password');

            if($username=='admin' && $password == 'FH@#2020$12'){
                $session->set('fmdb_user', 'success');
                return $this->redirect(['fmdb']);
            }
        }
        if (Yii::$app->request->post('logout')) {
            $session->remove('fmdb_user');
        }

        return $this->redirect(['fmdb']);
    }

    //fmdb export
    public function actionExport($id){
        $session = Yii::$app->session;
        if ($session->has('fmdb_user') && $session->get('fmdb_user')=='success'){
            header('Content-type: text/csv');
            header('Content-Disposition: attachment; filename="Diageo' . date('YmdHi') .'.csv"');
            if($id==1){
                $model= Educators::find()->asArray()->all();
                $model_label = new Educators();

            }elseif ($id==2) {
                $model= ProTrack::find()->asArray()->all();
                $model_label = new ProTrack();
            }elseif ($id==3) {
                $model= TrailSubmissions::find()->asArray()->all();
                $model_label = new TrailSubmissions();
            }
            $attributes = $model_label->attributes();
            $attribute_string = implode(',', $attributes)." \r\n";
            echo $attribute_string;
            foreach ($model as $data){
                $data_string = implode(',', $data)." \r\n";
                echo $data_string;
            }
            exit;
        }
        return $this->redirect(['fmdb']);
    }

    //fmdb upload file
    public function actionUpload(){
        $session = Yii::$app->session;
        if ($session->has('fmdb_user') && $session->get('fmdb_user')=='success'){
            $model = new Educators();
            if(Yii::$app->request->post()){
                $target_dir = Yii::$app->basePath  .'/web/assets/';
                $target_file = $target_dir . basename($_FILES["fmdb"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                if(isset($_POST["submit"])) {
                    $check = filesize($_FILES["fmdb"]["tmp_name"]);
                    if($check !== false) {
                        if(move_uploaded_file($_FILES["fmdb"]["tmp_name"], $target_file)){
                            echo "File successfully uploaded. File name is- " . basename($_FILES["fmdb"]["name"]);

                        }
                        $uploadOk = 1;
                    } else {
                        echo "File not uploaded";
                        $uploadOk = 0;
                    }
                     echo '<br>'.Html::a('Back', ['site/fmdb']);
                }
            }else{
                $url = Url::toRoute('site/upload');
                echo '<form action='.$url.' method="post" enctype="multipart/form-data">
                Select image to upload:
                <input type="file" name="fmdb" id="fmdb">
                <input type="hidden" name="'.Yii::$app->request->csrfParam.'" value="'. Yii::$app->request->csrfToken.'" />

                <input type="submit" value="Upload" name="submit">
                </form>';
                echo '<br>'.Html::a('Back', ['site/fmdb']);
            }
        }else{
            return $this->redirect(['fmdb']);
        }
    }

    public function avgsession($times) { 

        $output = '00:00:00';
        if($times >= 0){
            $seconds = round($times);
            $output = sprintf('%02d:%02d:%02d', ($seconds/ 3600),($seconds/ 60 % 60), $seconds% 60);
        }
        return $output;
       
    }

    public function p($o, $exit = false, $dump = false)
    {
        echo '<pre>';
        if ($dump) var_dump($o); else print_r($o);
        echo '</pre>';
        if ($exit || true) exit;
    }

    public function ssoAuthorize($header_data){
        $service_url = 'https://oauth.dxc.mktg.run/verify';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_URL, $service_url);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer '.$header_data['token'],
            'Content-type:application/json;charset=utf-8',
        ));

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $curl_response = curl_exec($curl);
        $response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        if($response_code !=200){
            return $emptyData = [];
        }
        // if ($curl_response === false) {
        //     $info = curl_getinfo($curl);
        //     print_r('Curl error: ' . curl_error($curl));
        //     curl_close($curl);
        //     return $emptyData = [];
        //     //die('error occured during curl exec. Additioanl info: ' . var_export($info));
        // }
        curl_close($curl);
        $data = $curl_response;
        
        $formatted_data = json_decode($data);
        
        return !empty($formatted_data)? $formatted_data->user : [];
    }


    public function actionSsoLogin(){
        $this->layout = 'login';
        $authorizeLink = 'https://dxc.mktg.run/';
        if(empty($_SESSION["referer"])){
            session_start();
        }
        
        if(!empty($_SERVER['HTTP_REFERER'])){
            $_SESSION["referer"]  = $_SERVER['HTTP_REFERER'];
        }

        $referer = empty($_SERVER['HTTP_REFERER']) ?  $_SESSION["referer"] : $_SERVER['HTTP_REFERER'];

        if($referer != $authorizeLink){
            return $this->redirect(['site/sso-unauthorize']);
        }

        if(!empty(Yii::$app->request->get('token'))){
            $data['token'] = Yii::$app->request->get('token');
            $response = $this->ssoAuthorize($data);
            
            if(empty($response)){
                return $this->redirect(['site/sso-unauthorize']);
            }
            $user_model = User::find()->select('id,email')->where(['email' => $response->email])->one();

            if(empty($user_model)){    
               $user =  new User();
               $password = 'Dreambridge123';
               $user->email = $response->email;
               $user->username = $response->email;
               $user->first_name = $response->firstName;
               $user->last_name = $response->lastName;
               $user->setPassword($password);
               $user->save(false);
               $user_model = User::find()->select('id,email')->where(['email' => $response->email])->one();
            }

            if(!empty($response->email) && !empty($user_model)){
                $user_model->first_name = $response->firstName;
                $user_model->last_name = $response->lastName;
                $user_model->save(false);
                if(Yii::$app->user->identity->email != $response->email){
                    Yii::$app->user->login($user_model);
                }
                
                return $this->redirect(['cocktail/index']);
            }else{
                return $this->redirect(['site/sso-unauthorize']);
            }
        }else{
            return $this->redirect(['site/sso-unauthorize']);
        }
    }


    public function actionSsoUnauthorize() {
        return $this->render('sso_unauthorize',['name'=>'Unauthorize Login']);
    }
    


}
