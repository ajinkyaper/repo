<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Educators */

$this->title = 'Markets';
$this->params['breadcrumbs'][] = ['label' => 'Market', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div class="educators-create">

        <h1><?= Html::encode($this->title) ?></h1>

        <?=
        $this->render('_form', [
            'model' => $model,
        ])
        ?>

    </div>
</div>
