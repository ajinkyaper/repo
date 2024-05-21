<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $model app\models\Categories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categories-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'category_name')->textInput(['maxlength' => true]) ?>
	<div class="custom-control custom-switch">
		<input class="custom-control-input" id="switch" name="switch" type="checkbox" <?php echo $model->status == 0 ? 'checked' : ''; ?>>
		<label class="custom-control-label">
			<span class="active_status">
				<?php echo $model->status == 0 ? 'Active' : 'Inactive'; ?>
			</span> 

		</label>
	</div>
	<?= $form->field($model, 'status')->textInput() ?>

	<div class="form-group">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs('

	$(document).on("click", ".custom-control-label", function(e) { 
		var status = $(this).parent("div").find(".custom-control-input").prop("checked") == true ? 1 : 0 ;
		var _this = $(this);
			$("#categories-status").val(status);

			if(status==1){
                _this.parent("div").find(".custom-control-input").removeAttr("checked");
                _this.find(".active_status").html("Inactive");
            }else{
                _this.parent("div").find(".custom-control-input").attr("checked","checked");
                _this.find(".active_status").html("Active");
            }

		});

		', View::POS_READY);

		?>