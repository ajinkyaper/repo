<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Occasions';

$assets = Yii::$app->assetManager->baseUrl . '/';
$images = $assets . 'images/';

$uploads = Yii::$app->request->baseUrl . '/' . 'uploads/';

$occasionImage = $images . "thumbnail-default.jpg";
if (!empty($occasion->image)) {
  $occasionImage = $uploads . 'occasions/' . $occasion->image;
}
?>

<?php $this->beginBlock('headerblock') ?>
<div class="col-lg-8 col-sm-4"><a href="<?= Url::toRoute(['occasion/index']); ?>" class="title-link">
    <h1><?= Html::encode($this->title) ?></h1>
  </a></div>

<?php $this->endBlock() ?>

<?php $this->beginBlock('searchblock') ?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= Url::to(['/occasion']) ?>">List</a></li>
    <li class="breadcrumb-item active" aria-current="page">View</li>
  </ol>
</nav>
<?php $this->endBlock() ?>

<div class="contents">
  <p><a style="color: #fff;" href="<?= Url::to(['update?id=' . $occasion->id]) ?>" class="btn btn-danger sm-mb-20">Edit</a> <a style="color: #fff;" href="<?= Url::to(['/occasion']) ?>" class="btn btn-secondary sm-mb-20">Back</a></p>

  <div class="well">
    <label>Occasion Name</label>
    <div><?= $occasion->name ?></div>
  </div>

  <div class="row sm-mt-40">
    <div class="col-sm-7 disabled">
      <label class="text-red">Occasion Description</label>
      <p class="disabled"><?= nl2br($occasion->description) ?></p>
      <div class="row sm-mt-40">
        <div class="col-sm-6 disabled disabled">
          <label class="text-red">The Occasion</label>
          <p class="disabled"><?= nl2br($occasion->the_occasion) ?></p>
          <!-- <ul class="list-unstyled">
            <li>At home Alone or with Partner Relaxing</li>
            <li>Everyday Activities Later During the Day</li>
          </ul> -->
        </div>
        <div class="col-sm-6 disabled">
          <label class="text-red">The Mood</label>
          <p class="disabled"><?= nl2br($occasion->the_mood) ?></p>
          <!-- <ul class="list-unstyled">
            <li>Fun & Relaxing, letting go of the hectic day.</li>
            <li>More lively mood, pick me up moment</li>
          </ul> -->
        </div>
      </div>
      <div class="row sm-mt-30">
        <div class="col-sm-6 disabled">
          <label class="text-red">The Drink</label>
          <p class="disabled"> <?= nl2br($occasion->the_drink) ?></p>
          <!-- <ul class="list-unstyled">
            <li>High alcohol, easy to drink prepare, fizzy </li>
            <li>something everyone else enjoys</li>
          </ul> -->
        </div>
        <div class="col-sm-6 disabled">
          <label class="text-red">Who</label>
          <p class="disabled"><?= nl2br($occasion->who) ?></p>
          <!-- <ul class="list-unstyled">
            <li>Middle aged to older, with strong 50+ years old</li>
            <li>skew. Slight Female skew</li>
          </ul> -->
        </div>
      </div>
    </div>
    <div class="col-sm-5">
      <label class="text-red">Image</label>
      <p><img src="<?= $occasionImage ?>" alt="" class="thumbnail img-responsive" /></p>
    </div>
  </div>
</div>