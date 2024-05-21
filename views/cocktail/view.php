<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Cocktails';
$this->params['breadcrumbs'][] = ['label' => 'Coktail', 'url' => ['index'], 'currentPage'=> 'view'];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php $this->beginBlock('headerblock') ?>
   <div class="col-lg-8 col-sm-4"><a href="<?= Url::toRoute(['cocktail/index']); ?>" class="title-link"><h1><?= Html::encode($this->title) ?></h1></a></div>
   
<?php $this->endBlock() ?>

<?php $this->beginBlock('searchblock') ?>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo Url::toRoute(['cocktail/index']); ?>">List</a></li>
      <li class="breadcrumb-item active" aria-current="page">View</li>
    </ol>
  </nav>
<?php $this->endBlock() ?>

<?=
  $this->render('_form', [
    'model' => $model,
  ])
?>