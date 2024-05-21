<?php

namespace app\controllers;

use Yii;
use app\models\Market;
use app\models\Cocktail;
use app\models\CocktailSearch;
use app\models\CocktailOccasion;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CoktailController implements the CRUD actions for Cocktail model.
 */
class CocktailController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'rename-file'],
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
        $searchModel = new CocktailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


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
        $model = new Cocktail();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {


            if ($model->uploaded_image != "") {
                $model->image = Yii::$app->cms->uploadFile('cocktail', $model->uploaded_image);
            }
            $model->save(false);
            foreach ($model->Occasions as $key => $value) {
                $ocassion_model = new CocktailOccasion();
                $ocassion_model->occasion_id = $value;
                $ocassion_model->cocktail_id = $model->id;
                $ocassion_model->save();
            }

            Yii::$app->cms->updateSyncDataTime();
            Yii::$app->session->setFlash('success', "Cocktail added successfully");
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
                $model->image = Yii::$app->cms->uploadFile('cocktail', $model->uploaded_image, $model->image);
            }

            $model->save(false);
            CocktailOccasion::deleteAll(['AND', 'cocktail_id = ' . $id, ['NOT IN', 'occasion_id', $model->Occasions]]);
            foreach ($model->Occasions as $key => $value) {
                $ocassion_model = CocktailOccasion::findOne(['cocktail_id' => $id, 'occasion_id' => $value]);
                if (!$ocassion_model) {
                    $ocassion_model = new CocktailOccasion();
                }
                $ocassion_model->occasion_id = $value;
                $ocassion_model->cocktail_id = $model->id;
                $ocassion_model->save();
            }



            Yii::$app->cms->updateSyncDataTime();
            Yii::$app->session->setFlash('success', "Cocktail updated successfully");
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
        if (($model = Cocktail::findOne($id)) !== null) {
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

                $model->is_active =  $data['status'] == 1 ? 0 : 1;
                if ($model->save()) {
                    Yii::$app->cms->updateSyncDataTime();
                    $result = array('status' => 'success', 'data' => $model->is_active);
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
