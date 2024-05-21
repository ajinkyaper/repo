<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Educators */

$this->title = 'Cocktails';
$this->params['breadcrumbs'][] = ['label' => 'Coktail', 'url' => ['index'], 'currentPage'=> 'create'];
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $this->beginBlock('headerblock') ?>
<div class="col-lg-8 col-sm-4"><h1><?= Html::encode($this->title) ?></h1></div>

<?php $this->endBlock() ?>
<?php $this->beginBlock('searchblock') ?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo Url::toRoute(['cocktail/index']); ?>" class="title-link">List</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add New</li>
  </ol>
</nav>
<?php $this->endBlock() ?>
  <?=
	$this->render('_form', [
	    'model' => $model,
	])
  ?>