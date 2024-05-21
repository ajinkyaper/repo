<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Categories */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?php $this->beginBlock('headerblock') ?>
<div class="col-lg-3 col-sm-4"><h1><?= Html::encode($this->title) ?></h1></div>
<div class="col-lg-5 col-sm-4">

</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('searchblock') ?>
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="#">Update New Category</a></li>
	</ol>
</nav>
<?php $this->endBlock() ?>

<div class="contents">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>