<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Categories;
use yii\helpers\ArrayHelper;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\BrandDetails */
/* @var $form yii\widgets\ActiveForm */

$dataList = ArrayHelper::map(Categories::find()->orderBy('id')->all(),'id','category_name');
$isView = $this->params['breadcrumbs'][0]['currentPage'] == 'view' ? true : false;
echo $activeLabel = $model->status == 1 ? 'Active' : 'Inactive';
$isChecked = $model->status == 1 ? 'checked=checked' : '';
?>
  <?php $form = ActiveForm::begin(['id' =>'brand_form', 
       'enableClientValidation' => false ]); ?>
<div class="contents">
  <p><?php if(!$isView){ ?>
      <p>  <?= Html::Button($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-danger sm-mb-20' : 'btn btn-danger sm-mb-20', 'id'=> 'submit_btn']) ?>
        <?= Html::a('Cancel', ['brands/index'], ['class' => 'btn btn-secondary sm-mb-20']) ?> 
      </p>
        <?php }else{ ?>
          <p> 
        <?= Html::a('Edit', ['brands/update/?id='.$model->id], ['class' => 'btn btn-danger sm-mb-20']) ?> 
        <?= Html::a('Back', ['brands/index'], ['class' => 'btn btn-secondary sm-mb-20']) ?>
      </p>
      <?php  } ?></p>
  
    <div class="row">
    <div class="col-lg-6 col-sm-8">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Brand name</label>
        <div class="col-sm-8">

           <?= $form->field($model, 'brand_name')->textInput(['rows' => 3, 'disabled'=> $isView])->label(false) ?>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Select Category</label>
        <div class="col-sm-8">
            <?= $form->field($model, 'category_id')->dropDownList($dataList,['prompt'=>'Select Category', 'disabled'=> $isView, 'class'=>'form-control'])->label(false) ?>
          
        </div>
      </div>
      <div class="form-group row">
        <label for="inputPassword" class="col-sm-4 col-form-label">Status</label>
        <div class="col-sm-8 form-group sm-mt-10">
            <div class="custom-control custom-switch sm-mt-10">
              <input type="checkbox" class="custom-control-input is_active" id="switch0" name="BrandDetails[status]" <?= $isChecked ?>>
              <label class="custom-control-label" for="switch0"><?= $activeLabel ?></label>
            </div>
        </div>
      </div>
      </div>
    </div> 
  </div>


  <?php ActiveForm::end(); ?>
  <?php
$this->registerJs('
    $("#submit_btn").click(function(){
        
        //e.preventDefault();
        // e.stopImmediatePropagation();
        var brand_form = $("#brand_form");
        
        if(brand_form.valid()){

            $("#brand_form").submit();          
        }
          $( "#marque_form" ).validate({
    
    debug: false,
    rules: {
      "BrandDetails[brand_name]": {
        required: true
      },
      "BrandDetails[category_id]": {
        required: true
      }
    },
    messages:{
      "BrandDetails[brand_name]": {
        required: "Brand name cannot be blank"
      },
      "BrandDetails[category_id]": {
        required: "Please select category"
      }      
    }
  });

    });
        $(document).on("click", ".custom-control-label", function(e) { 
        var status = $(this).parent("div").find(".custom-control-input").prop("checked") == true ? 1 : 0 ;
        var _this = $(this);
            $("#categories-status").val(status);

            if(status==0){
                _this.parent("div").find(".custom-control-input").removeAttr("checked");
                _this.find(".active_status").html("Inactive");
            }else{
                _this.parent("div").find(".custom-control-input").attr("checked","checked");
                _this.find(".active_status").html("Active");
            }

        });
');
?>