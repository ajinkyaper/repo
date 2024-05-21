<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\MomentV3;
use app\models\MomentV3Search;

/**
 * AdminuserController implements the CRUD actions for User model.
 */
class MomentController extends Controller
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
                'only' => ['index', 'update'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {



        $this->layout = 'main_new';
        $searchModel = new MomentV3Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $params = Yii::$app->request->queryParams;


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
        return $this->render('view', [
            'moment' => $this->findModel($id),
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post();
            if ($model->validate()) {
                $image = $model->uploaded_image;
                if ($image) {
                    $model->image = Yii::$app->cms->uploadFile('moments', $model->uploaded_image, $model->image);
                }
                $model->save(false);


                Yii::$app->cms->updateSyncDataTime();
                Yii::$app->session->setFlash('success', 'Moment updated succesfully');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    protected function findModel($id)
    {
        if (($model = MomentV3::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
