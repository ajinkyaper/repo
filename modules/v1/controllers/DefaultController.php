<?php

namespace app\modules\v1\controllers;

use yii\web\Controller;
use app\models\Educators;

/**
 * Default controller for the `v1` module
 */
class DefaultController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $rs = [
            'status' => 0,
            'msg' => 'Invalid request',
            'token' => '',
            'data' => array()
        ];
        return [];
        //        return $this->render('index', ['edu' => $model]);
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
