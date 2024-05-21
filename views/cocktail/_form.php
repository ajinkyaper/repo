<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Marques;
use yii\helpers\ArrayHelper;
use app\models\OccasionV3;
use yii\web\View;
use kartik\select2\Select2;

$dataList = ArrayHelper::map(Marques::find()->orderBy('id')->all(), 'id', 'name');
$occassionList = ArrayHelper::map(OccasionV3::find()->orderBy('id')->all(), 'id', 'name');
$selectedOccasion = isset($model->cocktailOccasion) ? ArrayHelper::map($model->cocktailOccasion, 'occasion_id', 'cocktail_id') : [];
if (!$selectedOccasion && !empty($model->Occasions)) {
  $selectedOccasion = array_flip($model->Occasions);
}

$isView = $this->params['breadcrumbs'][0]['currentPage'] == 'view' ? true : false;
$isChecked = $model->is_active == 1 ? 'checked=checked' : '';
$activeLabel = $model->is_active == 1 ? 'Active' : 'Inactive';
$instructions = $model->instructions;

$isEditable = $this->params['breadcrumbs'][0]['currentPage'] == 'view' ? 1 : 0;
$default_image_url = Yii::$app->request->baseUrl . '/img/thumbnail-default.jpg';

$image_url = (isset($model->image) && file_exists(Yii::$app->assetManager->basePath . '/../uploads/cocktail/' . $model->image)) ? Yii::$app->request->baseUrl . '/uploads/cocktail/' . $model->image : $default_image_url;
$isParentEnabled = isset($model->id) ? Marques::find()->where(['id' => $model->marque_id])->andWhere(['status' => 1])->count() : 1;
?>
<?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

<div class="contents">
  <?php if (!$isView) { ?>
    <p> <?= Html::Button($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-danger sm-mb-20' : 'btn btn-danger sm-mb-20', 'id' => 'submit_btn']) ?>
      <?= Html::a('Cancel', ['cocktail/index'], ['class' => 'btn btn-secondary sm-mb-20']) ?>
    </p>
  <?php } else { ?>
    <p>
      <?= Html::a('Edit', ['cocktail/update/?id=' . $model->id], ['class' => 'btn btn-danger sm-mb-20']) ?>
      <?= Html::a('Back', ['cocktail/index'], ['class' => 'btn btn-secondary sm-mb-20']) ?>
    </p>
  <?php  } ?>
  <div class="well sm-mb-30">
    <div class="row">
      <div class="col-sm-4">
        <div> <?= $form->field($model, 'name')->textInput(['rows' => 3, 'disabled' => $isView]) ?></div>
      </div>
      <div class="col-sm-4">

        <div>
          <?php echo $form->field($model, 'marque_id', ['options' => ['class' => 'form-group custom-select-box edit']])->widget(Select2::class, [
            'data' => $dataList,
            'hideSearch' => true,
            'options' => ['placeholder' => 'Select Marque', 'autocomplete' => 'off'],
            'pluginOptions' => [
              'allowClear' => false,

            ],
          ])->label('Marques')
          ?>

        </div>
      </div>
      <div class="col-sm-4">
        <label>Status</label>
        <div class="custom-control custom-switch" data-key="<?= $model->id ?>" data-status="<?= $model->is_active ?>">
          <input type="hidden" name="Cocktail[is_active]" id="switchInput" value="<?= $model->is_active ?>">
          <input type="checkbox" class="custom-control-input <?php echo $flag = ($isParentEnabled == 0 || $isView == true) ? 'cancel-click' : ''; ?>" id="switchpop" value="0" <?= $isChecked ?> />
          <label class="custom-control-label <?php echo $flag = ($isParentEnabled == 0 || $isView == true) ? 'cancel-click' : ''; ?>" id="switchpopLabel" for="switchpop" data-isEdit="<?= $isEditable ?>">
            <?= $model->is_active == 1 ? 'Active' : 'Inactive' ?>
          </label>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-7">
      <div class="row">
        <div class="col-sm-6">
          <label class="text-red">Ingredients</label>
          <input type="hidden" name="Cocktail[ingredients]" id="ingredientList" />
          <div class="editor <?= $isView == true ? 'disabled' : '';  ?>" id="editor0">
            <?= $model->ingredients ?>
          </div>

          <div id="ingredientError" class="error"><?php echo Html::error($model, 'ingredients'); ?></div>

        </div>
        <div class="col-sm-6">
          <label class="text-red">Instructions</label>
          <input type="hidden" name="Cocktail[instructions]" id="instructionList" />
          <div class="editor <?= $isView == true ? 'disabled' : '';  ?>" id="editor1">
            <?= $model->instructions ?>
          </div>
          <div id="instructionError" class="error"><?php echo Html::error($model, 'instructions'); ?></div>

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
              <input class="form-check-input" type="checkbox" id="gridCheck<?= $key ?>" name="Cocktail[Occasions][]" value="<?= $key ?>" <?= $checked ?> <?= $isView ? 'disabled' : ''  ?>>
              <label class="form-check-label" for="gridCheck<?= $key ?>"><?= $value ?></label>
            </div>

          <?php $i++;
          } ?>
        </div>
        <label id="Cocktail[Occasions][]-error" class="error" for="Cocktail[Occasions][]"></label>
        <?php echo Html::error($model, 'Occasions'); ?>
      </div>
    </div>
    <div class="col-sm-5">

      <label class="text-red">Image</label>
      <div class="d-flex">
        <div class="img-view" id="occ-imgView">
          <img id="uploaded_img" src="<?= $image_url ?>" alt="" style="height: 300px;" />
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
  
  var isUploaded = 0;
  BalloonEditor
    .create( document.querySelector( "#editor0" ), {toolbar: [ "bold", "italic", "bulletedList" ], isReadOnly: true} )
    .then( (editor) => {
      console.log("now in editor");
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
            console.log("ingredient empty", isEmpty);
            if(isEmpty){
             $("#ingredientError").html("Ingredient cannot be blank");
            }else{
              $("#ingredientError").html("");
            }
        });
      } ).then()    
    .catch( err => {console.error( err.stack ); } );


  BalloonEditor
   .create( document.querySelector( "#editor1" ), {toolbar: [ "bold", "italic", "bulletedList" ]} )
    .then( editor => {
      window.editor1 = editor;
      var is_view = "' . $isEditable . '";
      var editable = false;
      console.log("is_view1", is_view);
      if(is_view==1){
        editable = false;
      }else{
        editable = true;
      }
      $("#editor1").prop("contenteditable", editable);
          editor.model.document.on( "change:data", ( evt, data ) => {
            var emptyVal = "<p></p>";
            var isEmpty = editor.getData() == "" || editor.getData() == "<p><br data-cke-filler=\"true\"></p>" ? 1 : 0;
            console.log("instruction empty", isEmpty);
            if(isEmpty){
              $("#instructionError").html("Instruction cannot be blank");
            }else{

              $("#instructionError").html("");
            }
          });
      })    
    .catch( err => {console.error( err.stack ); } );



  $( "#w0" ).validate({
    
    debug: false,
    rules: {
      "Cocktail[name]": {
        required: true,
        maxlength: 250
      },
      "Cocktail[image]": {
        required: true
      },
      "Cocktail[Occasions][]": {
        required: true,
        minlength: 1
      },
      "Cocktail[marque_id]": {
        required: true
      },
      "Cocktail[instructions]": {
        required: true
      },
      "Cocktail[ingredients]": {
        required: true
      },
  

    },
    messages:{
      "Cocktail[name]": {
        required: "Cocktail Name Cannot Be Blank",
        maxlength: "Cocktail name cannot be greater than 250 character"
      },
      "Cocktail[image]": {
        required: "Please Upload Image"
      },
      "Cocktail[Occasions][]": { 
        required: "Please Select Occasion",
        minlength :"Plase Select Occsaiom"
      },
      "Cocktail[marque_id]": {
          required: "Please Select Marque"
      },
      "Cocktail[instructions]": {
          required: "Instructions Cannot be Blank"
      },
      "Cocktail[ingredients]": {
        required: "Ingredients Cannot be Blank"
      },
      "Cocktail[url]": {
        url: "Please enter valid url"
      }
    },

  });

      $("#submit_btn").click(function(){


      var cocktail_form = $("#w0");
      var dummy = "<p><br data-cke-filler=\"true\"></p>";
      var inputVal = $("#editor0").html()== dummy ? "" : $("#editor0").html();
      var inputVal1 = $("#editor1").html()== dummy ? "" : $("#editor1").html();
      var flag  = true;
      var currentPage = "' . $this->params["breadcrumbs"][0]["currentPage"] . '";
      if(currentPage=="update"){
      $("#upload").rules("remove");          
      }
      if(inputVal==""){
        $("#ingredientError").html("Instruction cannot be blank");
        flag=false;
      }

      if(inputVal1==""){
        $("#instructionError").html("Instruction cannot be blank");
        flag=false;
      }       
      $("#ingredientList").val(inputVal);//change input
      $("#instructionList").val(inputVal1);//change input

      if(cocktail_form.valid() && flag){
          //$("#submit_btn").prop("disabled", true);
          //$("#w0").off("submit");
          $("#w0").submit();
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
  //  if(isUploaded){
  //   $(".croppie").cropit("destroy");
  //  }
  //   readURL(this);
  // });

  $(document).on("click","#switchpopLabel",function(){  


        console.log("inside");
        var status = $(this).text() == "Inactive" ? 0 : 1;
        console.log("value",status);
        $("#switchInput").val(status);
        if(status==0){
          $("#switchpop").prop("checked", true);           
        }else{
          $("#switchpop").prop("checked", false);
        }  
      
  });
  ', View::POS_READY);

?>