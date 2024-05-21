<?php

use Yii;
use yii\helpers\Url;

$assets = Yii::$app->assetManager->baseUrl . '/';
$images = $assets . 'images/';
$js = $assets . 'js/';
$css = $assets . 'css/';
$baseUrl = Yii::getAlias('@web');
$cocktail_base_path = $baseUrl . '/uploads/cocktail/';
$marque_base_path = $baseUrl . '/uploads/marques/';
$csrfToken = \yii::$app->request->csrfToken;

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
  <script src="<?= $js; ?>jquery.min.js"></script>
  <script type="text/javascript">
    jQuery.fn.load = function(callback) {
      $(window).trigger("load", callback);
    };
    jQuery.fn.bind = function(callback) {
      $(window).trigger("on", callback);
    };
    jQuery.fn.unbind = function(callback) {
      $(window).trigger("off", callback);
    };
  </script>
  <script type='text/javascript' src='//footer.diageohorizon.com/dfs/master.js'></script>

  <style type="text/css">
    #print_part .logo-img-grid {
      display: flex;
      flex-direction: column;
      justify-content: center;
      height: 500px;
      background: #E8E8E8;
    }

    #print_part .blue-grid-txt {
      display: flex;
      flex-direction: column;
      justify-content: center;
      height: 518px;
    }

    #print_part .dmdd p {
      font-size: 25px;
    }

    #print_part .product-details-grid .product-img {
      margin-bottom: 10px;
    }

    #print_part .product-details-grid .product-details {
      padding: 30px;
    }

    #print_part .products h5 span {
      background: #fff;
    }



    /*@media (max-width: 480px) {
        .products img.for-mobile {
          display: none;
        }

        .products img.for-desktop {
          display: block;
        }

        .products h2 .title,
        .products img {
          float: none;
          width: auto;
          margin: auto;
        }
        .products img {
          margin-bottom: 20px;
        }
      }*/
    @media print {
      .product {
        page-break-inside: avoid;
      }

      .after {
        page-break-after: always;
      }

      .before {
        page-break-before: always;
      }

      .big {
        height: 11.9in;
      }
    }

    html {
      -webkit-print-color-adjust: exact;
    }
  </style>
</head>

<body class="consumer html-content" id="content">
  <div id="desktop-view">

    <div id="no_use">
      <div class="banner-grid">
        <div class="logo-img-grid">
          <img src="<?= $images ?>diageo-logo.svg" alt="" class="img-responsive">
        </div>
        <div class="logo-bottom-line">
        </div>
        <img src="<?= $images ?>banner-cr.png" alt="" class="img-responsive desktop">
        <img src="<?= $images ?>banner-cr-mob.png" alt="" class="img-responsive mobile">
      </div>

      <div class="dmdd">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 col-md-12 col-md-offset-2">
              <p>Thanks again for taking the time to discover a new favorite. We heard what you’re looking for and we’ve curated the perfect collection of personalized recommendations that we’re sure you’re going to love. So, grab a glass and enjoy.</p>
              <!-- <p class="xs-mt-40"  data-html2canvas-ignore="true"><span class="downloads"><a href="get-pdf?id=<?= $data[0]['speedrail_id'] ?>"  class="btn-download">Download My Drink Discoveries</a></span></p> -->
              <p class="xs-mt-40" data-html2canvas-ignore="true"><span class="downloads"><a href="javascript:void(0)" class="btn-download">Download My Drink Discoveries</a></span></p>

              <div class="xs-mt-40 xs-minus-mb-60"><a href="#" class=" btn btn-arrow"></a></div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="products xs-pt-30 sm-pb-50 xs-pb-30">
      <div class="cutoff-grid-1600">
        <div class="row">
          <?php $i = 0;
          $k = -2;
          foreach ($data as $key => $value) { ?>
            <?php if ($value['cocktail_name'] != '') {
              $i = $i + 1;
              $k = $k + 1; ?>
              <div class="col-md-6 sm-mt-50 xs-mt-30 after <?php echo $cond =  ($k % 4 == 0 || $i == 2) ? 'html2pdf__page-break' : ''; ?>">
                <div class="row product">

                  <div class="col-md-4 text-center"><img src="<?php echo $cocktail_base_path . $value['cocktail_image'] ?>" class="img-responsive for-desktop" alt="" /></div>
                  <div class="col-md-8">
                    <h2 class="clearfix">
                      <div class="title"><?php echo $value['cocktail_name'] ?></div>
                      <img src="<?php echo $cocktail_base_path . $value['cocktail_image'] ?>" class="img-responsive for-mobile" alt="" />
                    </h2>
                    <h5><span>Description</span></h5>
                    <?php echo $value['ingredients'] ?>
                    <h5><span>Cocktail Instructions</span></h5>
                    <?php echo $value['instructions'] ?>
                    <p class="xs-mt-40" data-html2canvas-ignore><a href="javascript:void(0)" onClick="addClickTrack(<?= $value['speedrail_id'] ?>,<?= $value['product_id'] ?>, '<?= $value['type'] ?>', '<?= $value['cocktail_url'] ?>');window.open('<?= $value['cocktail_url'] ?>')" class="btn-view">View Product Website</a></p>
                  </div>
                </div>
              </div>
            <?php } else {
              $i = $i + 1;
              $k = $k + 1; ?>
              <div class="col-md-6 sm-mt-50 xs-mt-30 big <?php echo $cond =  ($k % 4 == 0 || $i == 2) ? 'html2pdf__page-break' : ''; ?>">
                <div class="row">
                  <div class="col-md-4 text-center">
                    <img src="<?php echo $marque_base_path . $value['marque_image'] ?>" class="img-responsive for-desktop" alt="" />
                  </div>
                  <div class="col-md-8">
                    <h2 class="clearfix">
                      <div class="title"><?= $value['marque_name'] ?></div>
                      <img src="<?php echo $marque_base_path . $value['marque_image'] ?>" class="img-responsive for-mobile" alt="" />
                    </h2>
                    <h5><span>Description</span></h5>
                    <?= $value['description'] ?>
                    <p class="xs-mt-40" data-html2canvas-ignore><a href="javascript:void(0)" onClick="addClickTrack(<?= $value['speedrail_id'] ?>,<?= $value['product_id'] ?>, '<?= $value['type'] ?>', '<?= $value['marque_url'] ?>');window.open('<?= $value['cocktail_url'] ?>')" class="btn-view">View Product Website</a></p>
                  </div>
                </div>
              </div>
          <?php
            }
          }
          ?>
        </div>
      </div>
    </div>
  </div>

  <div id="print_part">
    <div id="no_use" class="html2pdf__page-break top-pdf-section">
      <div class="logo-img-grid">
        <img src="<?= $images ?>banner-cr.jpg" alt="" class="img-responsive">
      </div>
      <div class="dmdd">
        <div class="container">
          <div class="row">
            <div class="col-md-12 blue-grid-txt">
              <p>Thanks again for taking the time to discover a new favorite. We heard what you’re looking for and we’ve curated the perfect collection of personalized recommendations that we’re sure you’re going to love. So, grab a glass and enjoy.</p>
              <!-- <p class="xs-mt-40"  data-html2canvas-ignore="true"><span class="downloads"><a href="javascript:addScript();"  class="btn-download">Download My Drink Discoveries</a></span></p>
              
              <div class="xs-mt-40 xs-minus-mb-60"><a href="#" class=" btn btn-arrow" data-html2canvas-ignore="true"></a></div> -->
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="products xs-pt-30 sm-pb-50 xs-pb-30">
      <div class="container">
        <div>
          <?php $i = 0;
          $k = -2;
          foreach ($data as $key => $value) { ?>
            <?php if ($value['cocktail_name'] != '') {
              $i = $i + 1;
              $k = $k + 1; ?>
              <div class="sm-mt-50 xs-mt-30 after <?php echo $cond =  $i == count($data) ? '' : 'html2pdf__page-break'; ?>">
                <div class="product-details-grid">
                  <div class="product-img text-center"><img src="<?php echo $cocktail_base_path . $value['cocktail_image'] ?>" class="img-responsive" alt="" /></div>
                  <div class="product-details">
                    <h2><?php echo $value['cocktail_name'] ?></h2>
                    <h5><span>Description</span></h5>
                    <?php echo $value['ingredients'] ?>
                    <h5><span>Cocktail Instructions</span></h5>
                    <?php echo $value['instructions'] ?>
                    <p class="xs-mt-40"><a href="javascript:void(0)" onClick="addClickTrack(<?= $value['speedrail_id'] ?>,<?= $value['product_id'] ?>, '<?= $value['type'] ?>', '<?= $value['cocktail_url'] ?>')" class="btn-view">View Product Website</a></p>
                  </div>
                </div>
              </div>
            <?php } else {
              $i = $i + 1;
              $k = $k + 1; ?>
              <div class="sm-mt-50 xs-mt-30 big <?php echo $cond =  $i == count($data) ? '' : 'html2pdf__page-break'; ?>">
                <div class="product-details-grid">
                  <div class="product-img text-center">
                    <img src="<?php echo $marque_base_path . $value['marque_image'] ?>" class="img-responsive" alt="" />
                  </div>
                  <div class="product-details">
                    <h2><?= $value['marque_name'] ?></h2>
                    <h5><span>Description</span></h5>
                    <?= $value['description'] ?>
                    <p class="xs-mt-40"><a href="javascript:void(0)" onClick="addClickTrack(<?= $value['speedrail_id'] ?>,<?= $value['product_id'] ?>, '<?= $value['type'] ?>', '<?= $value['marque_url'] ?>')" class="btn-view">View Product Website</a></p>
                  </div>
                </div>
              </div>
          <?php
            }
          }
          ?>
        </div>
      </div>
    </div>
  </div>

  <div id="footer"></div>

</body>

</html>
<!-- Bootstrap core JavaScript -->

<script src="<?= $js; ?>bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<!--   <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js" integrity="sha256-c9vxcXyAG4paArQG3xk6DjyW/9aHxai2ef9RpMWO44A=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.1/html2pdf.bundle.min.js"></script>
<script type="text/javascript">
  $(document).on("click", ".btn-download", function() {
    window.print();
  });

  $("#print_part").hide();

  function addScript() {
    $("#print_part").show();
    var element = document.getElementById('print_part');

    var opt = {
      filename: 'speedrail.pdf',
      html2canvas: {
        scale: 3
      },
      jsPDF: {
        unit: 'in',
        format: 'letter',
        orientation: 'portrait'
      }
    }

    html2pdf(element, opt);
    $("#print_part").hide();
  }
</script>

<script type="text/javascript">
  url = 'brand-track';

  function addClickTrack(speed_rail_id, product_id, product_type, redirect_url) {

    $.ajax({
      type: "POST",
      url: url,
      async: false,
      data: {
        speed_rail_id: speed_rail_id,
        product_id: product_id,
        product_type: product_type,
        _csrf: "<?= $csrfToken ?>"
      },
      dataType: "json",
      success: function(response) {
        if (response.status == "success") {
          //window.location = redirect_url;
          window.open(
            redirect_url,
            '_blank' // <- This is what makes it open in a new window.
          );
        } else {

        }
      },
      error: function(exception) {}
    });
    return false;
  }
</script>
<noscript>
  <div style="position: fixed; left: 0px; right: 0px; top: 0px;bottom: 0px; zindex:
100001; background: #fff url(//www.diageoagegate.com/nojs-bg.png) center
center no-repeat;"></div>
</noscript>