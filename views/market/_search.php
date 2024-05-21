<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\BrandDetails;
use yii\helpers\ArrayHelper;
use app\models\OccasionV3;
/* @var $this yii\web\View */
/* @var $model app\models\CocktailSearch */
/* @var $form yii\widgets\ActiveForm */
// $brandList = ArrayHelper::map(BrandDetails::find()->orderBy('brand_name')->all(),'brand_name','brand_name');
// $occasionList = ArrayHelper::map(OccasionV3::find()->orderBy('id')->all(),'name','name');
$searchArr  = \Yii::$app->session->get('searchParams');
?>

<div>

	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
		'class' => "form-row"
	]);
	?>
	<div class="row">
		<?= $form->field($model, 'name', ['options' => ['class' => 'form-group col-sm-4']])->textInput(['placeholder' => "Market Name", 'class' => 'form-control', 'value' => isset($searchArr['name']) ? $searchArr['name'] : ''])->label(false) ?>

		<div class="form-group col-sm-4">
			<?= Html::submitButton('Search', ['class' => 'btn btn-danger']) ?>
		</div>
	</div>
	<?php ActiveForm::end(); ?>

</div>