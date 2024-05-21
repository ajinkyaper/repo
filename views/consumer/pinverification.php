<?php

use yii\helpers\Url;
use yii\helpers\Html;

$assets = Yii::$app->assetManager->baseUrl . '/';
$images = $assets . 'images/';
$js = $assets . 'js/';
$css = $assets . 'css/';
$url = Url::toRoute(['consumer/verify-otp']);


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

<body>
  <section class="passcode">
    <div class="container">
      <div class="pform">
        <form action="<?= $url ?>" method="POST" enctype="multipart/form-data" id="pin_form">
          <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()); ?>
          <p><img src="<?= $images; ?>logo_black.png" /></p>
          <h6 class="sm-mt-70 xs-mt-50">Enter Your Passcode</h6>
          <div class="digit-group">
            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="digit-1" name="digit[]" data-next="digit-2" inputmode="numeric" />
            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="digit-2" name="digit[]" data-next="digit-3" data-previous="digit-1" inputmode="numeric" />
            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="digit-3" name="digit[]" data-next="digit-4" data-previous="digit-2" inputmode="numeric" />
            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="digit-4" name="digit[]" data-next="digit-5" data-previous="digit-3" inputmode="numeric" />
            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="digit-5" name="digit[]" data-next="digit-6" data-previous="digit-4" inputmode="numeric" />
            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="digit-6" name="digit[]" data-previous="digit-5" inputmode="numeric" />
          </div>
          <label id="error" style="text-decoration-color: red;"></label>

          <div class="form-group">
            <button type="button" id="pin_submit" class="btn btn-default sm-mb-10">Enter</button>
          </div>
          <div class="row">
            <div class="col-sm-6"><a href="#">United States</a></div>
            <div class="col-sm-6"><a href="#">Conditions of Use</a></div>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- Bootstrap core JavaScript -->
  <script src="<?= $js; ?>jquery.min.js"></script>
  <script src="<?= $js; ?>bootstrap.min.js"></script>
  <script src="<?= $js; ?>jquery.validate.min.js"></script>
  <script>
    $('.digit-group').find('input').each(function() {
      $(this).attr('maxlength', 1);
      $(this).on('keyup', function(e) {
        var parent = $($(this).parent());

        if (e.keyCode === 8 || e.keyCode === 37) {
          var prev = parent.find('input#' + $(this).data('previous'));

          if (prev.length) {
            $(prev).select();
          }
        } else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
          var next = parent.find('input#' + $(this).data('next'));

          if (next.length) {
            $(next).select();
          } else {
            if (parent.data('autosubmit')) {
              parent.submit();
            }
          }
        }
      });
    });
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#pin_submit").click(function() {
        if (validateField()) {
          $("#error").html('');
          $("#pin_form").submit();
        } else {
          $("#error").html('Please enter Pin of 6 numbers');
        }
      });
      $(".digit-group input").keyup(function() {
        if (this.value.length == this.maxLength) {
          $(this).next('input').focus();
        }
      });
    });

    function validateField() {
      var flag = true;
      $('input[name ="digit[]"]').each(function() {

        if (this.value === '' || this.value === 'undefined') {

          flag = false;
        }
      });

      return flag;
    }
  </script>
</body>

</html>