<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div class="user-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
        </p>


        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                //'id',
                //'username',
//                'password',
//                'auth_key',
//                'access_token',
                //'password_reset_token',
                [
                   'label' => 'Email (Username)',
                   'value' => function ($model) {
                       return $model->email;
                   }
                ],
                //'email:email',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => [],
                    'header'=>'Actions',
                    'template' => '{view} {update} {activate} {deactivate}',
                    'buttons' => [
                        'activate' => function($url, $model, $key) {     // render your custom button
                            return Html::a('<span class="glyphicon glyphicon-ok-circle" ></span>',['adminuser/activate','id'=>$model->id],['title' => Yii::t('app', 'Activate')]);
                        },
                        'deactivate' => function($url, $model, $key) {     // render your custom button
                            return Html::a('<span class="glyphicon glyphicon-ban-circle" ></span>',['adminuser/deactivate','id'=>$model->id],['title' => Yii::t('app', 'Deactivate')]);
                        }
                    ],
                    'visibleButtons'=>[
                        'activate'=> function($model){
                              return ($model->id!=Yii::$app->user->identity->id && $model->status==1);
                         },
                        'deactivate'=> function($model){
                              return ($model->id!=Yii::$app->user->identity->id && $model->status==0);
                         },
                    ]
                ],
            ],
        ]);
        ?>


    </div>
</div>
