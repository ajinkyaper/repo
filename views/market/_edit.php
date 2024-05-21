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

<?php $form = ActiveForm::begin(['id' =>'market_form', 
       'enableClientValidation' => false ]); ?>


    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Market Name</label>
      <div class="col-sm-8">
          <?= $form->field($model, 'name')->textInput(['class'=>"form-control"])->label(false) ?>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-4 col-form-label">Status</label>
      <div class="col-sm-8  sm-mt-10 sm-mb-10">
        <div class="custom-control custom-switch" data-key="<?= $model->id ?>" data-status="<?= $model->status ?>">
          <input type="hidden" name="Market[status]" id="switchInput" value="<?= $model->status ?>">
          <input type="checkbox" class="custom-control-input" id="switchpop"  value="" <?= $isChecked ?> />


        <label class="custom-control-label" id ="switchpopLabel" for="switchpop">
          <?= $model->status  ==1 ? 'Active' : 'Inactive' ?>
        </label>
      </div>
      </div>
    </div>
    <input type="submit" class="btn btn-danger sm-mb-20" name="submit"/>

<?php ActiveForm::end(); ?>

<script type="text/javascript">
  $(document).ready(function(){


   $("#market_form").on("submit", function(e){

        console.log("herre");
        var market_form = $("#market_form");
        
        $( "#market_form" ).validate({
        
        debug: false,
        rules: {
          "Market[name]": {
            required: true,
            maxlength: 250
          }
        },
        messages:{
              "Market[name]": {
                required: "Market name cannot be blank",
                maxlength: "Market name cannot be greater than 250 character"
              }      
            }
        });
        var web = "<?= $web ?>";
        if(market_form.valid()){

        }else{
           e.preventDefault();
        }
    });
 });
</script>