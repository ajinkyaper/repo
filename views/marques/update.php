<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Marques';

$this->params['breadcrumbs'][] = ['label' => 'Marques', 'url' => ['index'], 'currentPage'=> 'update'];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $this->beginBlock('headerblock') ?>
<div class="col-lg-8 col-sm-4"><a href="<?= Url::toRoute(['marques/index']); ?>" class="title-link"><h1><?= Html::encode($this->title) ?></h1></a></div>

<?php $this->endBlock() ?>

<?php $this->beginBlock('searchblock') ?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo Url::toRoute(['marques/index']); ?>">List</a></li>
    <li class="breadcrumb-item active" aria-current="page">Update</li>
  </ol>
</nav>
<?php $this->endBlock() ?>
  <?=
	$this->render('_form', [
	    'model' => $model,
	])
  ?>