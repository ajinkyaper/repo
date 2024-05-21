<?php

use yii\helpers\Url;

$assets = Yii::$app->assetManager->baseUrl . '/';
$images = $assets . 'images/';
$js = $assets . 'js/';
$css = $assets . 'css/';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="<?= Url::base() . '/favicon.ico' ?>">
    <title>Discover a drink enhancement</title>
    <link href="<?= $css; ?>bootstrap.min.css" rel="stylesheet">
    <link href="<?= $css; ?>helper.css" rel="stylesheet">
    <link href="<?= $css; ?>styles.css" rel="stylesheet">
    <link href="<?= $css; ?>styles_new.css" rel="stylesheet">
</head>

<body class="loading">
    <div class="container-fluid loading-page">
        <div class="sm-mt-30">
            <img src="<?= $images; ?>dad-dt.png" class="img-responsive sm" alt="">
            <img src="<?= $images; ?>dad-dt-xs.png" class="img-responsive xs" alt="">
        </div>
        <section>
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-6 col-md-push-6 md-mt-30">
                        <p><img src="<?= $images; ?>logo.svg" class="img-responsive dad-logo" alt=""></p>
                        <!--<h1 class="text-white">We are stirring up <br />something special.</h1>-->
                        <!-- <p><img src="<?= $images; ?>title.png" class="img-responsive" alt=""></p> -->
                        <p class="error-tagline">
                            We are stirring up something special.
                        </p>
                        <hr>
                        <h3 class="text-white xs-mb-30">Please check back again soon.</h3>
                    </div>
                    <div class="col-md-5 col-md-pull-6"><img src="<?= $images; ?>lanthing-thumb.png" class="img-responsive" alt=""></div>
                </div>
            </div>
        </section>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="<?= $js; ?>jquery.min.js"></script>
    <script src="<?= $js; ?>bootstrap.min.js"></script>
</body>

</html>