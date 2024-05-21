<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\LoginScreenForm;
use app\models\LoginScreen;

/**
 * AdminuserController implements the CRUD actions for User model.
 */
class SettingsController extends Controller
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
                'only' => ['login-screen'],
                'rules' => [
                    [
                        'actions' => ['login-screen'],
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
    public function actionLoginScreen()
    {
        $model = new LoginScreenForm();

        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {

            if ($model->validate()) {

                if ($model->update()) {
                    Yii::$app->session->setFlash('success', 'Login screen updated successfully.');
                    return $this->redirect(['login-screen']);
                } else {
                    Yii::$app->session->setFlash('error', 'Error in login screen update');
                    return $this->redirect(['login-screen']);
                }
            }
        }

        $loginScreen = LoginScreen::find()->one();

        $model->login_screen = !empty($loginScreen) ? $loginScreen->image : null;


        return $this->render('login-screen', [
            'model' => $model
        ]);
    }
}
