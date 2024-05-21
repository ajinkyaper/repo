<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BackendOtpDetails */
/* @var $form ActiveForm */
?>
<div class="otp">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="otpBox">
    
    <h3 style="color: #fff;text-align: center;font-size:18px;margin-bottom:1.5em;letter-spacing:1.6px;">Please enter the 6-digit verification code we sent via Email</h3>

    <?= $form->field($model, 'otp')->textInput(['type' => 'number','class' => 'form-control inpt otp', 'id' => 'frm_date', 'autocomplete'=>"off"])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    
    <a href="<?php echo Url::toRoute(['site/login',]); ?>" class="bk2homLnk">Back to login</a>
    
    
    </div>
    
    <div style="background:rgba(0,0,0,.7);position: fixed;width:100%;height:100%;top:0;z-index:-1;left:0"></div>
    
    <?php ActiveForm::end(); ?>

</div><!-- otp -->
