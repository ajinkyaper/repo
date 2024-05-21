<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\BrandDetails */

$this->title = 'Brands';
$this->params['breadcrumbs'][] = ['label' => 'Brand Details', 'url' => ['index'], 'currentPage'=> 'update'];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?php $this->beginBlock('headerblock') ?>
<div class="col-lg-3 col-sm-4"><a href="<?= Url::toRoute(['brands/index']); ?>" class="title-link" ><h1><?= Html::encode($this->title) ?></h1></a></div>
<div class="col-lg-5 col-sm-4">

</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('searchblock') ?>
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="<?php echo Url::toRoute(['brands/index']); ?>" class="title-link">List</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="#" class="title-link">Update</a></li>
  
	</ol>
</nav>
<?php $this->endBlock() ?>

<div class="contents">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>