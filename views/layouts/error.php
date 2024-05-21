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
$assets = Yii::$app->assetManager->baseUrl . '/';
$images = $assets . 'images/';
$js = $assets . 'js/';
$css = $assets . 'css/';
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
    <link href="<?= $css; ?>helper.css" rel="stylesheet">
    <link href="<?= $css; ?>styles.css" rel="stylesheet">
    <link href="<?= $css; ?>styles_new.css" rel="stylesheet">
    <?php $this->head() ?>
    <style type="text/css">
        .error-wrapper {
            background-color: #e9e8e7;
            padding-top: 0px;
        }

        .site-error {
            margin: 30px 0px;
            font-family: "neue-haas-unica", sans-serif;
        }

        .site-error .error-title {
            margin-bottom: 24px;
            font-size: 24px;
            font-weight: 700;
            color: #000;
        }

        .site-error .error-link {
            font-size: 18px;
            font-weight: 600;
            color: #702baf;
            cursor: pointer;
            text-decoration: underline;
            transition: all 0.3s ease;
        }

        .site-error .error-link:hover {
            color: #551a8b;
            text-decoration: underline;
        }
    </style>
    <link rel="icon" type="image/x-icon" href="<?= Url::base() . '/favicon.ico' ?>">
</head>

<body class="error-wrapper">
    <?php $this->beginBody() ?>
    <div class="container-fluid ">


        <div class="sm-mt-30 xs-mb-30">
            <img src="<?= $images; ?>dad-dt-b.png" class="img-responsive sm" alt="">
            <img src="<?= $images; ?>dad-dt-xs-b.png" class="img-responsive xs" alt="">
        </div>
        <section>
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8  md-mt-30">
                        <div class="text-center">
                            <img src="<?= $images; ?>404.png" class="img-responsive" alt="">
                        </div>
                        <?php echo $content; ?>
                    </div>
                    <div class="col-md-2"></div>

                </div>
            </div>
        </section>
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>