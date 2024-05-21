<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Educators */
/* @var $form yii\widgets\ActiveForm */
$isChecked = $model->status == 1 ? 'checked=checked' : '';
$web = Yii::getAlias('@web');
$model->status = $model->status=='' ? 0 : $model->status;

?>

<?php $form = ActiveForm::begin(['id' =>'category_form', 
       'enableClientValidation' => false ]); ?>

      
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Category Name</label>
      <div class="col-sm-8">
          <?= $form->field($model, 'category_name')->textInput(['class'=>"form-control"])->label(false) ?>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-4 col-form-label">Status</label>
      <div class="col-sm-8 sm-mt-10 sm-mb-10">
        <div class="custom-control custom-switch" data-key="<?= $model->id ?>" data-status="<?= $model->status ?>">
          <input type="hidden" name="Categories[status]" id="switchInput" value="<?= $model->status ?>">
          <input type="checkbox" class="custom-control-input" id="switchpop"  value="0" <?= $isChecked ?> />
        <label class="custom-control-label" id ="switchpopLabel" for="switchpop">
          <?= $model->status  ==1 ? 'Active' : 'Inactive' ?>
        </label>
      </div>
      </div>
    </div>
    <input type="submit" id="submit_btn" class="btn btn-danger sm-mb-20" name="submit">
    
      <!-- <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Submit</button></p> -->

<?php ActiveForm::end(); ?>
<script type="text/javascript">
  $(document).ready(function(){


   $("#category_form").on("submit", function(e){

        console.log("herre");
        var category_form = $("#category_form");
        
        $( "#category_form" ).validate({
        
        debug: false,
        rules: {
          "Categories[category_name]": {
            required: true,
            maxlength: 250
          }
        },
        messages:{
              "Categories[category_name]": {
                required: "Category name cannot be blank",
                maxlength: "Cocktail name cannot be greater than 250 character"
              }      
            }
        });
        var web = "<?= $web ?>";
        if(category_form.valid()){
          //$("#category_form").submit();
        }else{
           e.preventDefault();
        }
    });
 });
</script>