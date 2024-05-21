<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';

?>



<?php
$form = ActiveForm::begin([
    'id' => 'login-form',
    'layout' => 'horizontal',
    'options' => [
        'class' => 'form-signin'
    ],
    'fieldConfig' => [
        'template' => "{label}\n{input}\n{error}",
        'labelOptions' => ['class' => 'sr-only'],
    ],
]);
?>
<div class="logo">
    <img src="../img/logo.png" alt="DIAGEO" />
</div>
<!--<h2 class="form-signin-heading">Login</h2>-->
<?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control inpt', 'placeholder' => 'Username']) ?>
<?= $form->field($model, 'password')->passwordInput(['class' => 'form-control inpt pwd', 'placeholder' => 'Password', 'autocomplete' => 'off']) ?>
<div class="form-group">
    <?= Html::submitButton('Login', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>
</div>
<div style="background:rgba(0,0,0,.7);position: fixed;width:100%;height:100%;top:0;z-index:-1;left:0"> </div>


<?php ActiveForm::end(); ?>