<?php

namespace app\controllers;

use Yii;
use app\models\Market;

use app\models\Marques;

use app\models\EducatorActivityTrackSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * MarquesController implements the CRUD actions for Marques model.
 */
class ActivityController extends Controller
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

    /**
     * Lists all Cocktail models.
     * @return mixed
     */
    public function actionIndex()
    {

        $this->layout = 'main_new';

        $searchModel = new EducatorActivityTrackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider = $searchModel;
        //$params = Yii::$app->request->queryParams;

        // if(isset($params['EducatorActivityTrack']) && count($params['EducatorActivityTrack'])>0){
        //     Yii::$app->session['searchParamsMarque'] = $params['MarquesSearch'];            
        // }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
}
