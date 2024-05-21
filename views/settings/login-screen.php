<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = 'Login Screen';

$assets = Yii::$app->assetManager->baseUrl . '/';
$images = $assets . 'images/';

$uploads = Yii::$app->request->baseUrl . '/' . 'uploads/';

$screen = $images . "thumbnail-default.jpg";
if (!empty($model->login_screen)) {
  $screen = $uploads . 'login_screen/' . $model->login_screen;
}
?>


<?php $this->beginBlock('headerblock') ?>
<div class="col-lg-8 col-sm-8">
  <h1><?= Html::encode($this->title) ?></h1>
</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('searchblock') ?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Login Screen</a></li>
  </ol>
</nav>
<?php $this->endBlock() ?>

<div class="contents login">

  <?php $form = ActiveForm::begin([
    'options' => [
      'id' => 'login-screen-form',
      'enctype' => 'multipart/form-data'
    ]
  ]); ?>

  <?php echo $form->field($model, 'screen')->hiddenInput()->label(false); ?>

  <p><?= Html::submitButton('Submit', ['class' => 'btn btn-danger sm-mb-20', 'name' => 'submit-button']) ?></p>

  <!-- <p><button type="button" class="btn btn-danger sm-mb-20">Submit</button></p> -->

  <div class="d-flex">
    <div class="text-red">Image</div>
    <div class="img-view" id="imgView">
      <img src="<?= $screen; ?>" alt="" />
    </div>
    <div class="btn-upload">
      <div class="actions">
        <a class="btn file-btn">
          <span>Browse Image</span>
          <input type="file" id="upload" class="img-upload" value="Choose a file" accept="image/*" />
        </a>
      </div>
    </div>
  </div>
</div>

<?php ActiveForm::end(); ?>
</div>

<!-----crope popup------>
<div class="modal fade" id="imguploadmodal" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div id="upload-img-view" class="upload-img-view"></div>
        <p class="text-center"><button type="button" class="upload-img-result btn btn-danger">Save</button></p>
      </div>
      <!--<div class="modal-footer text-center">
                <button type="button" class="upload-img-result btn btn-danger">Save</button>
            </div>-->
    </div>
  </div>
</div>
<!-----end crope popup------>