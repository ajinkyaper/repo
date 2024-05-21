<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        You are not authorize to login !
    </div>

    <p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        Please click  <a href="https://dxc.mktg.run/">here</a>  to login. Thank you.
    </p>

</div>
