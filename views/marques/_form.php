<?php

use yii\helpers\Html;
//use yii\helpers\CHtml;
use yii\widgets\ActiveForm;
use app\models\Marques;
use app\models\PriceRange;
use app\models\BrandDetails;
use yii\helpers\ArrayHelper;
use app\models\OccasionV3;
use yii\web\View;
use kartik\select2\Select2;

$dataList = ArrayHelper::map(BrandDetails::find()->orderBy('brand_name')->all(), 'id', 'brand_name');
$occassionList = ArrayHelper::map(OccasionV3::find()->orderBy('id')->all(), 'id', 'name');
$selectedOccasion = ArrayHelper::map($model->marquesOccasion, 'occasion_id', 'marques_id');
if (!$selectedOccasion && $model->scenario == 'create' && !empty($model->occasion_id)) {
  $selectedOccasion = array_flip($model->occasion_id);
}

$priceRange = ArrayHelper::map(priceRange::find()->orderBy('id')->all(), 'id', function ($model) {
  return $model['price'] > 0 ? str_repeat('$', $model['price']) : 0;
});


$isView = $this->params['breadcrumbs'][0]['currentPage'] == 'view' ? true : false;
$isChecked = $model->status == 1 ? 'checked=checked' : '';
$activeLabel = $model->status == 1 ? 'Active' : 'Inactive';
$isEditable = $this->params['breadcrumbs'][0]['currentPage'] == 'view' ? 1 : 0;

$default_image_url = Yii::$app->request->baseUrl . '/img/thumbnail-default.jpg';
$image_url = isset($model->image) ? Yii::$app->request->baseUrl . '/uploads/marques/' . $model->image : $default_image_url;
$isParentEnabled = isset($model->id) ? BrandDetails::find()->where(['id' => $model->brand_id])->andWhere(['status' => 1])->count() : 1;
?>
<?php $form = ActiveForm::begin([
  'id' => 'marque_form',
  'enableClientValidation' => false
]); ?>

<div class="contents">
  <?php if (!$isView) { ?>
    <p> <?= Html::Button($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-danger sm-mb-20' : 'btn btn-danger sm-mb-20', "id" => "submit_btn"]) ?>
      <?= Html::a('Cancel', ['marques/index'], ['class' => 'btn btn-secondary sm-mb-20']) ?>
    </p>
  <?php } else { ?>
    <p>
      <?= Html::a('Edit', ['marques/update/?id=' . $model->id], ['class' => 'btn btn-danger sm-mb-20']) ?>
      <?= Html::a('Back', ['marques/index'], ['class' => 'btn btn-secondary sm-mb-20']) ?>
    </p>
  <?php  } ?>
  <div class="well sm-mb-30">
    <div class="row">
      <div class="col-sm-4">
        <div> <?= $form->field($model, 'name')->textInput(['rows' => 3, 'disabled' => $isView]) ?></div>
      </div>
      <div class="col-sm-4">

        <div>
          <?php if ($isView) {
            echo $form->field($model, 'brand_id')->dropDownList($dataList, ['prompt' => 'Select Brand', 'disabled' => $isView]);
          } else {
            echo $form->field($model, 'brand_id', ['options' => ['class' => 'form-group custom-select-box edit']])->widget(Select2::class, [
              'data' => $dataList,
              'hideSearch' => true,
              'options' => ['placeholder' => 'Select Brand', 'autocomplete' => 'off'],
              'pluginOptions' => [
                'allowClear' => true,

              ],
            ])->label('Brand Name');
          }
          ?>
        </div>

      </div>
      <div class="col-sm-4">
        <label>Status</label>
        <div class="custom-control custom-switch" data-key="<?= $model->id ?>" data-status="<?= $model->status ?>">
          <input type="hidden" name="Marques[status]" id="switchInput" value="<?= $model->status ?>">
          <input type="checkbox" class="custom-control-input <?php echo $flag = $isParentEnabled == 0 ? 'cancel-click' : ''; ?>" id="switchpop" value="0" <?= $isChecked ?> />
          <label class="custom-control-label <?php echo $flag = ($isParentEnabled == 0 || $isView == true) ? 'cancel-click' : ''; ?>" id="switchpopLabel" for="switchpop">
            <?= $model->status  == 1 ? 'Active' : 'Inactive' ?>
          </label>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-7">
      <div class="row">
        <div class="col-sm-10">
          <label class="text-red">Description</label>

          <div class="editor <?= $isView == true ? 'disabled' : '';  ?>" id="editor0">
            <?= $model->description ?>
          </div>
          <input type="hidden" name="Marques[description]" id="description" />
          <div id="descriptionError" class="error"></div>
        </div>

      </div>
      <div class="sm-mt-50">
        <label class="text-red">Occasions</label>
        <div class="row">
          <?php $i = 0;
          foreach ($occassionList as $key => $value) {
            $checked = array_key_exists($key, $selectedOccasion) ? 'checked' : '';

          ?>

            <div class="form-check col-sm-6">
              <input class="form-check-input" type="checkbox" id="gridCheck<?= $i ?>" name="Marques[occasion_id][]" value="<?= $key ?>" <?= $checked ?> <?= $isView ? 'disabled' : ''  ?>>
              <label class="form-check-label" for="gridCheck<?= $i ?>"><?= $value ?></label>

            </div>

          <?php $i++;
          } ?>
        </div>
        <label id="Marques[occasion_id][]-error" class="error" for="Marques[occasion_id][]"></label>
      </div>
    </div>
    <div class="col-sm-5">

      <label class="text-red">Image</label>
      <div class="d-flex">
        <div class="col-md-5 text-center img-view" id="occ-imgView">
          <img id="uploaded_img" src="<?= $image_url ?>" alt="" style="height: 240px;" />
        </div>
        <?php if (!$isView) { ?>
          <div class="btn-upload sm-ml-30">
            <div class="actions">
              <a class="btn file-btn">
                <span>Browse Image</span>
                <input type="file" id="upload" <?= $isView ? 'disabled' : ''  ?> class="occ-img-upload" value="Choose a file" accept="image/*" />
              </a>
            </div>
          </div>
        <?php } ?>
      </div>
      <?php echo $form->field($model, 'uploaded_image')->hiddenInput(['id' => 'product_uploaded_image'])->label(false); ?>
      <div id="cocktailImgError" style="text-decoration-color: red;"></div>
      <!-----crope popup------>
      <div class="modal fade" id="occimguploadmodal" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <div id="occ-upload-img-view" class="occ-upload-img-view"></div>
              <p class="text-center"><button type="button" class="occ-upload-img-result btn btn-danger">Save</button></p>
            </div>
            <!-- <div class="modal-footer text-center">
                          <button type="button" class="occ-upload-img-result btn btn-danger">Save</button>
                      </div> -->
          </div>
        </div>
      </div>
      <!-----end crope popup------>

      <label class="text-red">CTA</label>
      <p>
        <?php if ($isView) { ?>
          <a href="<?= $model->url ?>" class="<?= $isView == true ? 'disabled' : '';  ?>" target="_blank"><?= $model->url ?></a>
        <?php } else { ?>
          <?= $form->field($model, 'url')->textInput(['rows' => 3])->label(false); ?>
        <?php } ?>
      </p>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-3">
      <label class="text-red">Price</label>
      <?php
      if (!$isView) {
        echo $form->field($model, 'price', ['options' => ['class' => 'form-group custom-select-box']])->widget(Select2::class, [
          'data' => $priceRange,
          'hideSearch' => true,
          'options' => ['placeholder' => 'Select Price', 'autocomplete' => 'off'],
          'pluginOptions' => [
            'allowClear' => true,
          ],
        ])->label(false);
      } else {
        echo $form->field($model, 'price')->dropDownList($priceRange, ['prompt' => '', 'disabled' => $isView])->label(false);
      }
      ?>

    </div>
  </div>
</div>
</div>
<?php ActiveForm::end(); ?>
<?php
$this->registerJsFile(
  '@web/js/cocktail.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);
?>
<?php
$this->registerJs('
  BalloonEditor
    .create( document.querySelector( "#editor0" ), {toolbar: [ "bold", "italic", "bulletedList" ]} )
    .then( editor => {
      window.editor = editor;
      var is_view = "' . $isEditable . '";
      var editable = false;
      console.log("is_view1", is_view);
      if(is_view==1){
        editable = false;
      }else{
        editable = true;
      }
      $("#editor0").prop("contenteditable", editable);
        editor.model.document.on( "change:data", ( evt, data ) => {
            var emptyVal = "<p></p>";
            var isEmpty = editor.getData() == "" || editor.getData() == "<p><br data-cke-filler=\"true\"></p>" ? 1 : 0;
            console.log("description empty", isEmpty);
            if(isEmpty){
             $("#descriptionError").html("Description cannot be blank");
            }else{
              $("#descriptionError").html("");
            }
        });
      } )    
    .catch( err => {console.error( err.stack ); } );
  jQuery.validator.addMethod("urlmatch", function(value, element, params) {
    isValid =  /((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)/i;
    return this.optional(element) || isValid.test(value);
  }, "please Enter valid url like www.abc");

  $( "#marque_form" ).validate({
    
    debug: false,
    rules: {
      "Marques[name]": {
        required: true,
        maxlength:250
      },
      "Marques[image]": {
        required: true
      },
      "Marques[occasion_id][]": {
        required: true,
        minlength: 1
      },
      "Marques[brand_id]": {
        required: true
      },
      "Marques[desription]": {
        required: true
      },
      "Marques[price]": {
        required: true
      },
      "Marques[url]": {
        urlmatch: true
      }

    },
    messages:{
      "Marques[name]": {
        required: "Marques Name Cannot Be Blank",
        maxlength: "Marques name cannot be greater than 250 character"
      },
      "Marques[image]": {
        required: "Please upload image"
      },
      "Marques[occasion_id][]": { 
        required: "Please select occasion",
        minlength :"Please select occasion"
      },
      "Marques[brand_id]": {
          required: "Please Select Brand"
      },
      "Marques[description]": {
          required: "Instructions cannot be blank"
      },
      "Marques[price]": {
        required: "Price cannot be blank"
      },
      "Marques[url]": {
        url: "Please enter url"
      }
    }
  });

  $("#submit_btn").click(function(){
        
        // e.preventDefault();
        // e.stopImmediatePropagation();
        var marque_form = $("#marque_form");
        var dummy = "<p><br data-cke-filler=\"true\"></p>";
        var inputVal = $("#editor0").html()== dummy ? "" : $("#editor0").html();
        var currentPage = "' . $this->params["breadcrumbs"][0]["currentPage"] . '";
        if(currentPage=="update"){
        $("#upload").rules("remove");          
        }
 
        var flag  = true;
        if(inputVal==""){
          $("#descriptionError").html("Description cannot be blank");
          flag=false;
        }

        $("#description").val(inputVal);

        if(marque_form.valid() && flag){
            //$("#marque_form").off("submit");
            $("#marque_form").submit();          
        }
    });

  // function readURL(input) {
  //   if (input.files && input.files[0]) {
  //     var reader = new FileReader();
      
  //     reader.onload = function(e) {
  //       $("#uploaded_img").attr("src", e.target.result);
        
  //     }
  //     reader.readAsDataURL(input.files[0]); // convert to base64 string
  //   }
  // }

  // $("#upload").change(function() {
  //   readURL(this);
  // });

   $(document).on("click","#switchpopLabel",function(){
        
          var status = $(this).text() == "Inactive" ? 0 : 1;
          console.log("value",status);
          $("#switchInput").val(status);
            if(status==0){
              console.log("here switching");
              $("#switchpop").prop("checked", true);           
            }else{
              $("#switchpop").prop("checked", false);
            }

        });
  ', View::POS_READY);

?>