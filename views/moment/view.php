<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Moments';

$assets = Yii::$app->assetManager->baseUrl . '/';
$images = $assets . 'images/';

$uploads = Yii::$app->request->baseUrl . '/' . 'uploads/';

$momentImage = $images . "thumbnail-default.jpg";
if (!empty($moment->image)) {
  $momentImage = $uploads . 'moments/' . $moment->image;
}
?>

<?php $this->beginBlock('headerblock') ?>
<div class="col-lg-8 col-sm-4"><a href="<?= Url::toRoute(['moment/index']); ?>" class="title-link">
    <h1><?= Html::encode($this->title) ?></h1>
  </a></div>

<?php $this->endBlock() ?>

<?php $this->beginBlock('searchblock') ?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= Url::to(['/moment']) ?>">List</a></li>
    <li class="breadcrumb-item active" aria-current="page">View</li>
  </ol>
</nav>
<?php $this->endBlock() ?>

<div class="contents">
  <p><a style="color: #fff;" href="<?= Url::to(['update?id=' . $moment->id]) ?>" class="btn btn-danger sm-mb-20">Edit</a> <a style="color: #fff;" href="<?= Url::to(['/moment']) ?>" class="btn btn-secondary sm-mb-20">Back</a></p>

  <div class="well sm-mb-30">
    <div class="row">
      <div class="col-sm-4 disabled">
        <label>Moments Name</label>
        <div><?= $moment->name ?></div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-7 disabled">
      <label class="text-red">Moments Description</label>
      <p><?= nl2br($moment->description) ?></p>
    </div>
    <div class="col-sm-5">
      <label class="text-red">Image</label>
      <p><img src="<?= $momentImage ?>" alt="" class="thumbnail img-responsive" /></p>
    </div>
  </div>
</div>