<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Categories */

$this->title = 'Moments';

$assets = Yii::$app->assetManager->baseUrl . '/';
$images = $assets . 'images/';

$uploads = Yii::$app->request->baseUrl . '/' . 'uploads/';

$momentImage = $images . "thumbnail-default.jpg";
if (!empty($model->image) and file_exists(Yii::$app->assetManager->basePath . '/../uploads/moments/' . $model->image)) {
  $momentImage = $uploads . 'moments/' . $model->image;
}

?>

<?php $this->beginBlock('headerblock') ?>
<div class="col-lg-3 col-sm-4">
  <h1><?= Html::encode($this->title) ?></h1>
</div>
<div class="col-lg-5 col-sm-4">

</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('searchblock') ?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= Url::to(['/moment']) ?>">List</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
  </ol>
</nav>
<?php $this->endBlock() ?>

<div class="contents">
  <?php $form = ActiveForm::begin([
    'options' => [
      'id' => 'moment-form',
      'enctype' => 'multipart/form-data'
    ]
  ]); ?>

  <?php echo $form->field($model, 'uploaded_image')->hiddenInput()->label(false); ?>

  <p>
    <button id="submit-btn" class="btn btn-danger sm-mb-20">Submit</button>
    <!-- <?= Html::submitButton('Submit', ['class' => 'btn btn-danger sm-mb-20', 'name' => 'submit-button']) ?> -->
    <a style="color: #fff;" href="<?= Url::to(['view?id=' . $model->id]) ?>" class="btn btn-secondary sm-mb-20">Cancel</a>
  </p>

  <div class="well custom-well sm-mb-30">
    <div class="row">
      <div class="col-sm-6">
        <?= $form->field($model, 'name')->textInput(array('placeholder' => 'Enter Moment Name'))->label('Moment Name'); ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-7 editor-wrapper">
      <label class="text-red">Moments Description</label>
      <input type="hidden" name="MomentV3[description]" id="description" />
      <!-- <?= $form->field($model, 'description')->textarea(['rows' => '2', 'id' => 'editor', 'class' => 'editor form-control'])->label(false) ?>        -->
      <div class="editor" id="mom-editor" style="height: 200px !important;">
        <?= $model->description ?>
      </div>
      <div id="descriptionError" class="help-block editor-error" style="display: none;">Description cannot be blank</div>
    </div>
    <div class="col-sm-5">
      <label class="text-red">Image</label>
      <div class="d-flex">
        <div class="img-view" id="mom-imgView">
          <img src="<?= $momentImage ?>" alt="" />
        </div>
        <div class="btn-upload sm-ml-30">
          <div class="actions">
            <a class="btn file-btn">
              <span>Browse Image</span>
              <input type="file" id="upload" class="mom-img-upload" value="Choose a file" accept="image/*" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php ActiveForm::end(); ?>
</div>

<!-----crope popup------>
<div class="modal fade" id="momimguploadmodal" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div id="mom-upload-img-view" class="mom-upload-img-view"></div>
        <p class="text-center"><button type="button" class="mom-upload-img-result btn btn-danger">Save</button></p>
      </div>
      <!--<div class="modal-footer text-center">
                <button type="button" class="mom-upload-img-result btn btn-danger">Save</button>
            </div>-->
    </div>
  </div>
</div>
<!-----end crope popup------>


<?php
$this->registerJsFile(
  '@web/js/moments.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);
?>