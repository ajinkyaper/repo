<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BrandSearch */
/* @var $form yii\widgets\ActiveForm */

$searchArr  = \Yii::$app->session->get('searchParams');
?>

<div>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <?= $form->field($model, 'brand_name', ['options' => ['class' => 'form-group col-sm-4']])->textInput(['placeholder' => "Brand"])->label(false) ?>
        <div class="form-group col-sm-4">
            <?= Html::submitButton('Search', ['class' => 'btn btn-danger']) ?>
            <?= Html::a('Reset', ['/brands/'], ['class' => 'btn btn-primary']); ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>