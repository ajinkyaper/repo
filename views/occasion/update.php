<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = 'Occasions';

$assets = Yii::$app->assetManager->baseUrl . '/';
$images = $assets . 'images/';

$uploads = Yii::$app->request->baseUrl . '/' . 'uploads/';

$occasionImage = $images . "thumbnail-default.jpg";
if (!empty($model->image)) {
  $occasionImage = $uploads . 'occasions/' . $model->image;
}

$imgValue = !empty($model->image) ? 'present' : '';
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
    <li class="breadcrumb-item"><a href="<?= Url::to(['/occasion']) ?>">List</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
  </ol>
</nav>
<?php $this->endBlock() ?>

<div class="contents occasion">

  <?php $form = ActiveForm::begin([
    'options' => [
      'id' => 'occasion-form',
      'enctype' => 'multipart/form-data'
    ]
  ]); ?>



  <input type="hidden" name="dummy_image_input" id="imgValidationInput" value="<?= $imgValue ?>">

  <p>
    <button id="submit-btn" class="btn btn-danger sm-mb-20">Submit</button>
    <!-- <?= Html::submitButton('Submit', ['class' => 'btn btn-danger sm-mb-20', 'name' => 'submit-button']) ?> -->
    <a style="color: #fff;" href="<?= Url::to(['view?id=' . $model->id]) ?>" class="btn btn-secondary sm-mb-20">Cancel</a>
  </p>

  <div class="well custom-well">
    <div class="row">
      <div class="col-sm-6">
        <?= $form->field($model, 'name')->textInput(array('placeholder' => 'Enter Occasion Name'))->label('Occasion Name'); ?>
        <!-- <label>Occasion Name</label>
        <input type="text" class="form-control" placeholder="Everyday evening at home" id=""> -->
      </div>
    </div>
  </div>

  <div class="row sm-mt-40">
    <div class="col-sm-7">
      <div class="editor-wrapper">
        <label class="text-red">Occasion Description</label>
        <input type="hidden" name="OccasionV3[description]" id="description" />
        <!-- <?= $form->field($model, 'description')->textarea(['rows' => '2', 'class' => 'form-control'])->label(false) ?> -->
        <div class="editor" id="desc-editor" style="height: 100px !important;">
          <?= $model->description ?>
        </div>
        <div id="descriptionError" class="help-block editor-error" style="display: none;">Description cannot be blank</div>
      </div>

      <div class="row sm-mt-40">
        <div class="col-sm-6 editor-wrapper">
          <label class="text-red">The Occasion</label>
          <input type="hidden" name="OccasionV3[the_occasion]" id="occasion" />
          <!-- <?= $form->field($model, 'the_occasion')->textarea(['rows' => '2', 'class' => 'form-control'])->label(false) ?> -->
          <div class="editor" id="occasion-editor" style="height: 100px !important;">
            <?= $model->the_occasion ?>
          </div>
          <div id="occasionError" class="help-block editor-error" style="display: none;">Occasion cannot be blank</div>
        </div>
        <div class="col-sm-6 editor-wrapper">
          <label class="text-red">The Mood</label>
          <input type="hidden" name="OccasionV3[the_mood]" id="mood" />
          <!-- <?= $form->field($model, 'the_mood')->textarea(['rows' => '2', 'class' => 'form-control'])->label(false) ?> -->
          <div class="editor" id="mood-editor" style="height: 100px !important;">
            <?= $model->the_mood ?>
          </div>
          <div id="moodError" class="help-block editor-error" style="display: none;">Mood cannot be blank</div>
        </div>
      </div>

      <div class="row sm-mt-40">
        <div class="col-sm-6 editor-wrapper">
          <label class="text-red">The Drink</label>
          <input type="hidden" name="OccasionV3[the_drink]" id="drink" />
          <!-- <?= $form->field($model, 'the_drink')->textarea(['rows' => '2', 'class' => 'form-control'])->label(false) ?> -->
          <div class="editor" id="drink-editor" style="height: 100px !important;">
            <?= $model->the_drink ?>
          </div>
          <div id="drinkError" class="help-block editor-error" style="display: none;">Drink cannot be blank</div>
        </div>
        <div class="col-sm-6 editor-wrapper">
          <label class="text-red">Who</label>
          <input type="hidden" name="OccasionV3[who]" id="who" />
          <!-- <?= $form->field($model, 'who')->textarea(['rows' => '2', 'class' => 'form-control'])->label(false) ?> -->
          <div class="editor" id="who-editor" style="height: 100px !important;">
            <?= $model->who ?>
          </div>
          <div id="whoError" class="help-block editor-error" style="display: none;">Who cannot be blank</div>
        </div>
      </div>
    </div>
    <div class="col-sm-5">
      <label class="text-red">Image</label>
      <div class="d-flex">
        <div class="img-view" id="occ-imgView">
          <img src="<?= $occasionImage ?>" alt="" />
        </div>
        <div class="btn-upload sm-ml-30">
          <div class="actions">
            <a class="btn file-btn">
              <span>Browse Image</span>
              <input type="file" id="upload" class="occ-img-upload" value="Choose a file" accept="image/*" />
            </a>
          </div>
        </div>
      </div>
      <?php echo $form->field($model, 'uploaded_image')->hiddenInput()->label(false); ?>
      <div class="help-block imgReqMsg" style="display: none;">Image is required.</div>
    </div>
    <?php ActiveForm::end(); ?>
  </div>

</div>

<!-----crope popup------>
<div class="modal fade" id="occimguploadmodal" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div id="occ-upload-img-view" class="occ-upload-img-view"></div>
        <p class="text-center"><button type="button" class="occ-upload-img-result btn btn-danger">Save</button></p>
      </div>
      <!--<div class="modal-footer text-center">
                <button type="button" class="occ-upload-img-result btn btn-danger">Save</button>
            </div>-->
    </div>
  </div>
</div>
<!-----end crope popup------>

<?php
$this->registerJsFile(
  '@web/js/occasions.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);
?>