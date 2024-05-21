<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" type="image/x-icon" href="<?= Url::base() . '/favicon.ico' ?>">
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Discover a Drink</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!--<li><a href="#">Logout</a></li>-->
                    <?php
                    if (!Yii::$app->user->isGuest) {
                        echo '<li>'
                            . Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                                'Logout (' . Yii::$app->user->identity->username . ')',
                                ['class' => 'btn btn-link logout']
                            )
                            . Html::endForm()
                            . '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <?php
    if (!Yii::$app->user->isGuest && Yii::$app->errorHandler->exception == null) { ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li class="<?php echo (Yii::$app->controller->id == "site" && Yii::$app->controller->action->id == "index") ? 'active' : ''; ?>"><a href="<?php echo Url::toRoute(['site/index']); ?>">Report <span class="sr-only">(current)</span></a></li>
                        <li class="<?php echo (Yii::$app->controller->id == "ipadusers" && Yii::$app->controller->action->id == "index") ? 'active' : ''; ?>"><a href="<?php echo Url::toRoute(['ipadusers/index']); ?>">iPad Users</a></li>
                        <li class="<?php echo (Yii::$app->controller->id == "adminuser" && Yii::$app->controller->action->id == "index") ? 'active' : ''; ?>"><a href="<?php echo Url::toRoute(['adminuser/index']); ?>">Admin Users</a></li>
                        <li class="<?php echo (Yii::$app->controller->id == "market" && Yii::$app->controller->action->id == "index") ? 'active' : ''; ?>"><a href="<?php echo Url::toRoute(['market/index']); ?>">Market</a></li>
                        <li class="<?php echo (Yii::$app->controller->id == "cocktail" && Yii::$app->controller->action->id == "index") ? 'active' : ''; ?>"><a href="<?php echo Url::toRoute(['cocktail/index']); ?>">Cocktail</a></li>
                    </ul>

                </div>

            </div>
        </div>
    <?php } ?>
    <!--<div class="wrap">-->
    <!--<div class="container">-->

    <?= Alert::widget() ?>
    <?= $content ?>
    <!--</div>-->
    <!--</div>-->
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>