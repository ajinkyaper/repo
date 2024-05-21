<?php

namespace app\controllers;

use Yii;
use app\models\BrandDetails;
use app\models\BrandSearch;
use app\models\Marques;
use app\models\Cocktail;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BrandsController implements the CRUD actions for BrandDetails model.
 */
class BrandsController extends Controller
{
    public $layout = "main_new";
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['create', 'update', 'index', 'delete', 'status-update', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
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
     * Lists all BrandDetails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BrandSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BrandDetails model.
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
     * Creates a new BrandDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BrandDetails();

        if ($model->load(Yii::$app->request->post())) {
            $model->status = $model->status == 'on' ? 1 : 0;
            $model->save();

            Yii::$app->cms->updateSyncDataTime();
            Yii::$app->session->setFlash('success', "Brands added successfully");
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BrandDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        $isPost = $model->load(Yii::$app->request->post());
        if ($isPost) {

            $model->status = $model->status == 'on' ? 1 : 0;
        }

        if ($isPost && $model->save()) {
            $this->updateDependent($model->status, $id);
            Yii::$app->cms->updateSyncDataTime();
            Yii::$app->session->setFlash('success', "Brands updated successfully");
            return $this->redirect(['index']);
        }


        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionStatusUpdate()
    {
        $result = array('status' => 'error');
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();

            $model = $this->findModel($data['id']);


            if (isset($model)) {
                $model->status =  $data['status'] == 1 ? 0 : 1;

                if ($model->save(false)) {
                    $this->updateDependent($model->status, $data['id']);
                    Yii::$app->cms->updateSyncDataTime();
                    $result = array('status' => 'success', 'data' => $data['status']);
                } else {
                    $result = array('status' => 'error', 'data' => $model->errors);
                }
            }
        }
        echo json_encode($result);
        exit;
    }

    /**
     * Deletes an existing BrandDetails model.
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
     * Finds the BrandDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BrandDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BrandDetails::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function updateDependent($status, $id)
    {
        Marques::updateAll(['status' => $status, 'updated_at' => date("Y-m-d H:i:s"), 'updated_by' => Yii::$app->user->identity->id], ['and', ['=', 'brand_id', $id]]);
        $marquesData =  Marques::find()->where(['brand_id' => $id])->asArray()->all();
        $marquesArr = array_column($marquesData, 'id');
        $condition = [
            'and',
            ['in', 'marque_id', $marquesArr],
        ];
        Cocktail::updateAll([
            'is_active' =>  $status, 'updated_at' => date("Y-m-d H:i:s"), 'updated_by' => Yii::$app->user->identity->id
        ], $condition);
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
