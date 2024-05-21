<?php

use yii\helpers\Url;

$assets = Yii::$app->assetManager->baseUrl . '/';
$images = $assets . 'images/';
$js = $assets . 'js/';
$css = $assets . 'css/';
$loginUrl = Url::toRoute(['site/login']);
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

<body class="landing">
  <div class="container-fluid">
    <div class="sm-mt-30 xs-mb-30"><img src="<?= $images; ?>dad-dt-b.png" class="img-responsive sm" alt=""><img src="<?= $images; ?>dad-dt-xs-b.png" class="img-responsive xs" alt=""></div>
  </div>
  <section>
    <div class="container text-center">
      <div class="row">
        <div class="col-sm-6 xs-mb-30">
          <p><img src="<?= $images; ?>dd-thumb.png" class="img-responsive" alt=""></p>
          <p>Open a world of possibilities with your personalized pairings, curated for you and your occasion. Explore all that’s in store and discover your new favorite cocktail with just a click.</p>
          <p><a href="<?= Url::toRoute(['consumer/pin-verification']); ?>"><button type="button" class="btn btn-default sm-mb-10">
                < To The Left</button></a></p>
        </div>
        <div class="col-md-6">
          <p><img src="<?= $images; ?>vt-thumb.png" class="img-responsive" alt=""></p>
          <p>Open a world of possibilities with your personalized pairings, curated for you and your occasion. Explore all that’s in store and discover your new favorite cocktail with just a click.</p>
          <p><button type="button" class="btn btn-default sm-mb-10">Right This Way ></button></p>
        </div>
      </div>
    </div>
  </section>

  <!-- Bootstrap core JavaScript -->
  <script src="<?= $js; ?>jquery.min.js"></script>
  <script src="<?= $js; ?>bootstrap.min.js"></script>
</body>

</html>