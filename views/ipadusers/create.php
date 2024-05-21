<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Educators */

$this->title = 'iPad User';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['index'], 'currentPage'=> 'create'];
$web = Yii::getAlias('@web');
?>

<?php $this->beginBlock('headerblock') ?>
<div class="col-sm-8"><a href="<?= Url::toRoute(['ipadusers/index']); ?>" class="title-link"><h1><?= Html::encode($this->title) ?></h1></a></div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('searchblock') ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= Url::to(['/ipadusers']) ?>">List</a></li>
        <li class="breadcrumb-item">Add New</li>
    </ol>
</nav>
<?php $this->endBlock() ?>

<div class="contents">
  <?=
    $this->render('_form', [
        'model' => $model,
    ])
  ?>
</div>
