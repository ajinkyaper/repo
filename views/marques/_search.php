<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\BrandDetails;
use yii\helpers\ArrayHelper;
use app\models\OccasionV3;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\CocktailSearch */
/* @var $form yii\widgets\ActiveForm */

$brandList = ArrayHelper::map(BrandDetails::find()->orderBy('brand_name')->all(), 'brand_name', 'brand_name');
$occasionList = ArrayHelper::map(OccasionV3::find()->orderBy('id')->all(), 'name', 'name');
?>

<div>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'class' => "form-row"
    ]);
    ?>
    <div class="row">
        <?= $form->field($model, 'name', ['options' => ['class' => 'form-group col-md-3']])->textInput(['placeholder' => "Marques", 'class' => 'form-control'])->label(false) ?>

        <?php echo $form->field($model, 'brand_name', ['options' => ['class' => 'form-group col-md-3 custom-select-box']])->widget(Select2::class, [
            'data' => $brandList,
            'hideSearch' => true,
            'options' => ['placeholder' => 'Select Brand', 'autocomplete' => 'off'],
            'pluginOptions' => [
                'allowClear' => true,

            ],
        ])->label(false);
        ?>

        <?php echo $form->field($model, 'occ_name', ['options' => ['class' => 'form-group col-md-4 custom-select-box']])->widget(Select2::class, [
            'data' => $occasionList,
            'hideSearch' => true,
            'options' => ['placeholder' => 'Select Occasion', 'autocomplete' => 'off'],
            'pluginOptions' => [
                'allowClear' => false,
            ],
        ])->label(false);
        ?>
        <div class="col-md-2">
            <?= Html::submitButton('Search', ['class' => 'btn btn-danger']) ?>
            <?= Html::a('Reset', ['/marques/'], ['class' => 'btn btn-primary']); ?>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>