<?php

namespace app\controllers;

use Yii;
use app\models\Educators;
use app\models\EducatorsSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * IpadusersController implements the CRUD actions for Educators model.
 */
class IpadusersController extends Controller
{
    public $layout = "main_new";

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'delete', 'activate', 'deactivate', 'status-update', 'generate-passcode'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'activate', 'deactivate', 'status-update', 'generate-passcode'],
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

    /**
     * Lists all Educators models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EducatorsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $params = Yii::$app->request->queryParams;
        $this->checkSessionUrl();
        if (isset($params['EducatorsSearch']) && count($params['EducatorsSearch']) > 0) {
            //var_dump($params['EducatorsSearch']);die();
            Yii::$app->session['searchParams'] = $params['EducatorsSearch'];
        }

        if (isset(Yii::$app->session['searchParams'])) {
            $data['EducatorsSearch'] = Yii::$app->session['searchParams'];
            $dataProvider = $searchModel->search($data);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Educators model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Educators model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Educators();

        if ($model->load(Yii::$app->request->post())) {
            $model->status = $model->is_active == 'on' ? 1 : 0;
            if ($model->validate() && $model->save()) {
                Yii::$app->cms->updateSyncDataTime();
                $logo = Yii::$app->urlManager->createAbsoluteUrl('/') . 'img/' . 'logo_new.png';
                $is_mailsend = \Yii::$app->mailer->compose(['html' => 'educator-registration'], ['email' => $model->email, 'logo' => $logo])
                    ->setFrom([\Yii::$app->params['smtpFrom'] => 'DIAGEO'])
                    ->setTo($model->email)
                    ->setSubject('Welcome To Discover A Drink : DIAGEO')
                    ->send();

                Yii::$app->session->setFlash('success', "Ipad User added successfully");
                return $this->redirect(['index']);
                // return $this->redirect(['view', 'id' => $model->edu_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Educators model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->status = $model->is_active == 'on' ? 1 : 0;
            if ($model->validate() && $model->save()) {
                Yii::$app->cms->updateSyncDataTime();
                Yii::$app->session->setFlash('success', "Ipad User updated successfully");
                return $this->redirect(['index']);
                // return $this->redirect(['view', 'id' => $model->edu_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Educators model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionActivate($id)
    {
        $model = $this->findModel($id);
        if ($model) {
            Yii::$app->cms->updateSyncDataTime();
            $model->status = 0; //0-activate
            $model->save(false);
        }
        return $this->redirect(['index']);
    }

    public function actionDeactivate($id)
    {
        $model = $this->findModel($id);
        if ($model) {
            Yii::$app->cms->updateSyncDataTime();
            $model->status = 1; //0-deactivate
            $model->save(false);
        }
        return $this->redirect(['index']);
    }

    public function actionStatusUpdate()
    {
        $result = array('status' => 'error');
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();

            $model = $this->findModel($data['id']);

            if (isset($model)) {
                $model->status =  $data['status'];
                if ($model->save(false)) {
                    Yii::$app->cms->updateSyncDataTime();
                    $result = array('status' => 'success', 'data' => $model->status);
                } else {
                    $result = array('status' => 'error', 'data' => $model->errors);
                }
            }
        }
        echo json_encode($result);
        exit;
    }

    public function actionGeneratePasscode()
    {
        $availableCodes = ArrayHelper::getColumn(Educators::find()->select('edu_pass')->all(), 'edu_pass');

        do {
            $passcode = rand(10000, 99999);
        } while (in_array($passcode, $availableCodes));

        $result = [
            'status' => 'success',
            'data' => [
                'code' => $passcode
            ]
        ];

        echo json_encode($result);
        exit;
    }

    /**
     * Finds the Educators model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Educators the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Educators::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    public function checkSessionUrl()
    {
        $prevUrl =  Yii::$app->request->referrer;
        $actual_url = substr($prevUrl, strpos($prevUrl, 'web') + 3);
        $actual_url = strpos($actual_url, '?') > 0 ? substr($actual_url, 0, strpos($actual_url, '?')) : $actual_url;
        $prev_controller = Yii::$app->createController($actual_url);
        $currentUrl = Yii::$app->request->url;
        $current_controller = Yii::$app->createController(substr($currentUrl, strpos($currentUrl, 'web') + 3));

        $prev_controller_name = isset($prev_controller[0]->id) ? $prev_controller[0]->id : '';
        $current_controller_name = isset($current_controller[0]->id) ? $current_controller[0]->id : '';
        $isSessionRemove = $current_controller_name != $prev_controller_name ? 1 : 0;

        if ($isSessionRemove) {
            Yii::$app->session['searchParams'] = [];
        }
    }
}
