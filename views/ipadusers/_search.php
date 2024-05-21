<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use app\models\Educators;
use yii\helpers\ArrayHelper;
use app\models\Market;
use kartik\select2\Select2;

$emailList = ArrayHelper::map(Educators::find()->orderBy('email')->all(), 'email', 'email');
$marketList = Market::find()->orderBy('name')->all();
$marketListData = ArrayHelper::map(Market::find()->orderBy('name')->all(), 'id', 'name');
$getData = Yii::$app->getRequest()->getQueryParam('EducatorsSearch');
$selectedMarkets = !empty($getData['market']) ? $getData['market'] : [];
$searchArr  = \Yii::$app->session->get('searchParams');
$selectedMarkets = isset($selectedMarkets) ? $selectedMarkets : [];
$selectedMarkets = isset($searchArr['market']) ? $searchArr['market'] : $selectedMarkets;
$marketText = '';
$i = 0;

foreach ($selectedMarkets as $key => $marketId) {
  foreach ($marketList as $index => $market) {
    if ($market->id == $marketId) {
      $marketText .= (($i != 0) ? ', ' : '') . $market->name;
      $i++;
    }
  }
}

$marketText = !empty($marketText) ? $marketText : 'Select an option';
$selctedEmail = isset($searchArr['email']) ? $searchArr['email'] : '';
$selectedOccasion = isset($searchArr['edu_name']) ? $searchArr['edu_name'] : '';
?>

<?php $form = ActiveForm::begin([
  'action' => ['index'],
  'method' => 'get',
  'class' => "form-row"
]);
?>

<div class="form-row">
  <?= $form->field($model, 'edu_name', ['options' => ['class' => 'form-group col-md-3']])->textInput(['placeholder' => "Name", 'class' => 'form-control',  'value' => isset($searchArr['edu_name']) ? $searchArr['edu_name'] : ''])->label(false) ?>

  <?php echo $form->field($model, 'email', ['options' => ['class' => 'form-group col-md-4 custom-select-box']])->widget(Select2::class, [
    'data' => $emailList,
    'hideSearch' => true,
    'options' => ['placeholder' => 'Select Email', 'value' => [$selctedEmail], 'autocomplete' => 'off'],
    'pluginOptions' => [
      'allowClear' => false,
    ],
  ])->label(false);
  ?>

  <div class="form-group col-md-3">
    <div class="multiselect">
      <div class="selectBox">
        <select class="form-control">
          <option><?= $marketText ?></option>
        </select>
        <div class="overSelect"></div>
      </div>
      <div id="checkboxes">
        <?php $i = 0;
        foreach ($marketList as $key => $value) {
          $checked = in_array($value->id, $selectedMarkets) ? 'checked' : '';
        ?>
          <label for="<?= $value->id ?>">
            <input type="checkbox" id="<?= $value->id ?>" value="<?= $value->id ?>" <?= $checked ?> name="EducatorsSearch[market][]" /><?= $value->name ?></label>
        <?php $i++;
        } ?>
      </div>
    </div>
  </div>
  <div class="form-group col-md-1">
    <?= Html::submitButton('Search', ['class' => 'btn btn-danger']) ?>
  </div>
</div>

<?php ActiveForm::end(); ?>

<?php
$this->registerJs('

  var expanded = false;

  $(document).on("click", ".selectBox", function(e) {
    var checkboxes = document.getElementById("checkboxes");
    if (!expanded) {
      checkboxes.style.display = "block";
      expanded = true;
    } else {
      checkboxes.style.display = "none";
      expanded = false;
    }
  });

', View::POS_READY);

?>