<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;

use app\models\Market;
use kartik\select2\Select2;

$isChecked = $model->status == 0 ? '' : 'checked=checked';
$activeLabel = $model->status == 0 ? 'Inactive' : 'Active';
//$isView = $this->params['breadcrumbs'][0]['currentPage'] == 'view' ? true : false;

/* @var $this yii\web\View */
/* @var $model app\models\Educators */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'ipadusers-form'
    ]
]); ?>

<p>
    <?= Html::submitButton('Submit', ['class' => 'btn btn-danger sm-mb-20', 'name' => 'submit-button']) ?>
    <a style="color: #fff;" class="btn btn-secondary sm-mb-20 backBtn">Cancel</a>
</p>

<div class="row">
    <div class="col-sm-8">
        <div class="form-group row">
            <label class="col-lg-3 col-sm-4 col-form-label">Name</label>
            <div class="col-sm-8">
                <?= $form->field($model, 'edu_name')->textInput(array('placeholder' => 'Enter Educator Name'))->label(false); ?>
                <!-- <input type="text" class="form-control" id="" value=""> -->
            </div>
        </div>
        <!--             <div class="form-group row">
                <label class="col-lg-3 col-sm-4 col-form-label">Passcode</label>
                <div class="col-sm-8">

                </div> 
            </div> -->

        <?php
        $market_data  = Market::find()->where(['status' => 1])->orderBy('name ASC')->all();
        $listData = ArrayHelper::map($market_data, 'id', 'name');
        ?>

        <div class="form-group row">
            <label class="col-lg-3 col-sm-4 col-form-label">Market</label>
            <div class="col-sm-8">
                <?php echo $form->field($model, 'city', ['options' => ['class' => 'form-group custom-select-box edit-columnn']])->widget(Select2::class, [
                    'data' => $listData,
                    'hideSearch' => true,
                    'options' => ['placeholder' => 'Select Market', 'autocomplete' => 'off'],
                    'pluginOptions' => [
                        'allowClear' => true,

                    ],
                ])->label(false)
                ?>

            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword" class="col-lg-3 col-sm-4 col-form-label">Status</label>
            <div class="col-sm-8 form-group sm-mt-10">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="switchpop1" name="Educators[is_active]" <?= $isChecked ?>>
                    <label class="custom-control-label" for="switchpop1"><?= $activeLabel ?></label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-sm-4 col-form-label">Email id</label>
            <div class="col-sm-8">
                <?= $form->field($model, 'email')->textInput(array('placeholder' => 'Enter Educator Email id'))->label(false); ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
<script type="text/javascript">
    var passcodeUrl = "<?= Yii::$app->getUrlManager()->createUrl('ipadusers/generate-passcode') ?>";
</script>

<?php
$this->registerJs('

    $(document).on("click", ".backBtn", function(e) {
        e.preventDefault();
        window.history.back();
    });

    $(document).on("click", ".generate-passcode", function(e) { 
        e.preventDefault();
        $.ajax({
            type: "GET",
            dataType: "json",
            url: passcodeUrl,
            success: function(response)
            {
                if(response.status == "success") {
                    $("#educators-edu_pass").val(response.data.code);
                }
            }
        });
    });
', View::POS_READY);
?>

<?php
$this->registerJs('

  $(document).on("click", ".backBtn", function(e) {
    e.preventDefault();
    window.history.back();
  });
  
', View::POS_READY);
?>