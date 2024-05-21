<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Educators */

$this->title = 'iPad User';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$isChecked = $model->status == 1 ? 'checked=checked' : '';
$activeLabel = $model->status == 1 ? 'Active' : 'Inactive';

?>

<?php $this->beginBlock('headerblock') ?>
<div class="col-sm-8"><a href="<?= Url::toRoute(['ipadusers/index']); ?>" class="title-link"><h1><?= Html::encode($this->title) ?></h1></a></div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('searchblock') ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= Url::to(['/ipadusers']) ?>">List</a></li>
      <li class="breadcrumb-item active" aria-current="page">View</li>
    </ol>
</nav>
<?php $this->endBlock() ?>

<div>
<div class="contents">
  <p><a style="color: #fff;" href="<?= Url::to(['update?id='.$model->edu_id]) ?>" class="btn btn-danger sm-mb-20">Edit</a> <a style="color: #fff;" class="btn btn-secondary sm-mb-20 backBtn">Back</a></p>
  <!-- <p><button type="button" class="btn btn-danger sm-mb-20">Submit</button> <button type="button" class="btn btn-secondary sm-mb-20">Cancel</button></p> -->
  
    <div class="row">
    <div class="col-sm-8">
      <div class="form-group row">
        <label class="col-lg-3 col-sm-4 col-form-label">Name</label>
        <div class="col-sm-8"><?= $model->edu_name ?></div>
      </div>
<!--       <div class="form-group row">
        <label class="col-lg-3 col-sm-4 col-form-label">Passcode</label>
        <div class="col-sm-8"> </div> 
      </div> -->
      <div class="form-group row">
        <label class="col-lg-3 col-sm-4 col-form-label">Market</label>
        <div class="col-sm-8"><?= $model->market->name ?></div>
      </div>
      <div class="form-group row">
        <label for="inputPassword" class="col-lg-3 col-sm-4 col-form-label">Status</label>
        <div class="col-sm-8 form-group sm-mt-10">
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input cancel-click" id="switch" name="switch" <?= $isChecked ?> >
            <label class="custom-control-label cancel-click" for="switch" style="pointer-events: none;"><?= $activeLabel ?></label>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-lg-3 col-sm-4 col-form-label">Email</label>
        <div class="col-sm-8 sm-mt-5"><?= $model->email ?></div>
      </div>
      </div>
    </div> 
          
  </div>
</div>

<?php
$this->registerJs('

  $(document).on("click", ".backBtn", function(e) {
    e.preventDefault();
    window.history.back();
  });
  
', View::POS_READY);
?>