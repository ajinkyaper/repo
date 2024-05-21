<?php

namespace app\controllers;

use Yii;
use app\models\Market;
use app\models\MarketSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * MarketController implements the CRUD actions for Market model.
 */
class MarketController extends Controller
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
     * Lists all Market models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'main_new';

        $searchModel = new MarketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->checkSessionUrl();
        $params = Yii::$app->request->queryParams;
        if (isset($params['MarketSearch']) && count($params['MarketSearch']) > 0) {
            Yii::$app->session['searchParams'] = $params['MarketSearch'];
        }
        if (isset(Yii::$app->session['searchParams'])) {
            $data['MarketSearch'] = Yii::$app->session['searchParams'];
            $dataProvider = $searchModel->search($data);
        }


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Displays a single Market model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEdit($id)
    {
        $this->layout = false;
        return $this->render('_edit', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Market model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Market();
        $this->layout = false;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cms->updateSyncDataTime();
            Yii::$app->session->setFlash('success', "Market added successfully");
            return $this->redirect(['index']);
        }

        return $this->render('_edit', [
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
        $model = $this->findModel($id);
        $this->layout = false;
        // var_dump(Yii::$app->request->post());
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cms->updateSyncDataTime();
            Yii::$app->session->setFlash('success', "Market updated successfully");
            return $this->redirect(['index']);
        }

        return $this->render('_edit', [
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
        if (($model = Market::findOne($id)) !== null) {
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

                $model->status =  $data['status'];
                if ($model->save()) {
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

    public function checkSessionUrl()
    {
        $prevUrl =  isset(Yii::$app->request->referrer) ? Yii::$app->request->referrer : "";
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
