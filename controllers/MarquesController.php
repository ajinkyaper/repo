<?php

namespace app\controllers;

use Yii;
use app\models\Market;
use app\models\Cocktail;
use app\models\Marques;
use app\models\MarquesSearch;
use app\models\MarquesOccasion;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

/**
 * MarquesController implements the CRUD actions for Marques model.
 */
class MarquesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
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
     * Lists all Cocktail models.
     * @return mixed
     */
    public function actionIndex()
    {

        $this->layout = 'main_new';

        $searchModel = new MarquesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $params = Yii::$app->request->queryParams;
        // $this->checkSessionUrl();
        // if(isset($params['MarquesSearch']) && count($params['MarquesSearch'])>0){
        //     Yii::$app->session['searchParamsMarque'] = $params['MarquesSearch'];            
        // }

        // if(isset(Yii::$app->session['searchParamsMarque'])){
        //     $data['MarquesSearch'] = Yii::$app->session['searchParamsMarque'];
        //     $dataProvider = $searchModel->search($data);
        // }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Market model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = 'main_new';
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Market model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'main_new';
        $model = new Marques();
        //$model->scenario = 'create';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {


            if ($model->uploaded_image != "") {
                $model->image = Yii::$app->cms->uploadFile('marques', $model->uploaded_image);
            }
            $model->save(false);
            foreach ($model->occasion_id as $key => $value) {
                $ocassion_model = new MarquesOccasion();
                $ocassion_model->occasion_id = $value;
                $ocassion_model->marques_id = $model->id;
                $ocassion_model->save();
            }

            Yii::$app->cms->updateSyncDataTime();
            Yii::$app->session->setFlash('success', "Marques added successfully");
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Market model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout = 'main_new';
        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $image = $model->uploaded_image;
            if ($image) {
                $model->image = Yii::$app->cms->uploadFile('marques', $model->uploaded_image, $model->image);
            }
            $model->save(false);
            MarquesOccasion::deleteAll(['AND', 'marques_id = ' . $id, ['NOT IN', 'occasion_id', $model->occasion_id]]);
            foreach ($model->occasion_id as $key => $value) {
                $ocassion_model = MarquesOccasion::findOne(['marques_id' => $id, 'occasion_id' => $value]);
                if (!$ocassion_model) {
                    $ocassion_model = new MarquesOccasion();
                }
                $ocassion_model->occasion_id = $value;
                $ocassion_model->marques_id = $model->id;
                $ocassion_model->save();
            }

            $this->updateDependent($model->status, $id);

            Yii::$app->cms->updateSyncDataTime();
            Yii::$app->session->setFlash('success', "Marques updated successfully");
            return $this->redirect(['index']);
        }



        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Market model.
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



    /**
     * Finds the Market model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Market the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Marques::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStatusUpdate()
    {
        $result = array('status' => 'error');
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();

            $model = $this->findModel($data['id']);

            if (isset($model)) {

                $model->status =  $data['status'] == 1 ? 0 : 1;
                if ($model->save()) {
                    $this->updateDependent($model->status, $data['id']);
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





    public function updateDependent($status, $id)
    {
        Cocktail::updateAll(['is_active' => $status, 'updated_at' => date("Y-m-d H:i:s"), 'updated_by' => Yii::$app->user->identity->id], ['and', ['=', 'marque_id', $id]]);
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
            Yii::$app->session['searchParamsMarque'] = [];
        }
    }
}
