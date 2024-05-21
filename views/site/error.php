<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <!-- <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div> -->

    <h4 class="error-title">
        Sorry, we can't seem to find the page you're looking for.
</h4>
<a href="<?php echo Url::toRoute(['/']); ?>" class="error-link">Return Home</a>

</div>
