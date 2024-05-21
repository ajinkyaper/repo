<?php
use yii\helpers\Url;
$baseUrl = Url::base(true);
$assets = $baseUrl . '/assets/';
$images = $assets . 'images/';
$js = $assets . 'js/';
$css = $assets . 'css/';

$cocktail_base_path = $baseUrl.'/uploads/cocktail/';
$marque_base_path = $baseUrl.'/uploads/marques/';
$csrfToken = \yii::$app->request->csrfToken;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- <link href="<?= $images ?>favicon.ico" rel="shortcut icon"> -->
  <title>Discover a drink enhancement</title>
  <link href="<?= $css; ?>bootstrap.min.css" rel="stylesheet">
  <link href="<?= $css; ?>helper.css" rel="stylesheet">
  <link href="<?= $css; ?>styles.css" rel="stylesheet">
  <link href="<?= $css; ?>styles_new.css" rel="stylesheet">  
  <script src="<?= $js; ?>jquery.min.js"></script>
  <script src="<?= $js; ?>bootstrap.min.js"></script>

  <style type="text/css">

      #print_part .logo-img-grid {
      	display: flex;
        flex-direction: column;
        justify-content: center;
        background: #E8E8E8;
      }
      #print_part .blue-grid-txt {
        height: 818px;
      }

      #print_part .blue-grid-txt p {
        padding: 320px 100px 0;
      }

      #print_part .dmdd p {
      	font-size: 25px;
      }

      #print_part .product-details-grid .product-img {
        margin: 0 0 10px;
        padding: 60px 0 0;
      }

      #print_part .product-details-grid .product-details {
        padding: 0 30px;
      }

      #print_part .products h5 span {
          background: #e9e8e7;
      }

    @media print {
      .product {page-break-inside: avoid;}
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
    .html2pdf__page-break { page-break-before: always; } 
html { -webkit-print-color-adjust: exact; }
  </style>
</head>
<body class="consumer html-content" id="content">

<div id="print_part">
  <div id="no_use" class="top-pdf-section">
    <div class="logo-img-grid">
    	<img src="<?= $images ?>banner-cr.jpg" alt="" class="img-responsive">
    </div>
    <div class="dmdd" >
      <div class="container">
        <div class="row"> 
            <div class="col-md-12 blue-grid-txt">
              <p>Thanks again for taking the time to discover a new favorite. We heard what you’re looking for and we’ve curated the perfect collection of personalized recommendations that we’re sure you’re going to love.  So, grab a glass and enjoy.</p>
            </div>
        </div>
       </div>
    </div>
  </div>

  <div class="products"  style="background-color: #e9e8e7;">
      <div class="container" >
        <div>
          <?php $i =-1; $k=-2;  foreach ($data as $key => $value) { ?>
              <?php if($value['cocktail_name'] != ''){  $i = $i+1; $k = $k+1;?>
              <div class="<?php echo $cond =  $i==count($data) ? '' : 'html2pdf__page-break'; ?>">
                  <div class="product-details-grid">
                      <div class="product-img text-center"><img src="<?php echo $cocktail_base_path.$value['cocktail_image'] ?>" class="img-responsive" alt="" /></div>
                      <div class="product-details">
                          <h2><?php  echo $value['cocktail_name']?></h2>
                          <h5><span>Description</span></h5>
                          <?php echo $value['ingredients'] ?>
                          <h5><span>Cocktail Instructions</span></h5>
                          <?php echo $value['instructions'] ?>
                          <p class="xs-mt-40"><a  href="<?= $value['cocktail_url'] ?>" target="_blank" class="btn-view">View Product Website</a></p>
                      </div>
                  </div>
              </div>
              <?php }else{ $i = $i+1;  $k = $k+1; ?>
              <div class="big <?php echo $cond =  $i==count($data) ? '' : 'html2pdf__page-break'; ?>">
                  <div class="product-details-grid">
                      <div class="product-img text-center">
                          <img src="<?php echo $marque_base_path.$value['marque_image'] ?>" class="img-responsive"  alt="" /></div>
                      <div class="product-details">
                          <h2><?= $value['marque_name'] ?></h2>
                          <h5><span>Description</span></h5>
                          <?= $value['description'] ?>
                          <p class="xs-mt-40"><a href="<?= $value['marque_url'] ?>" target="_blank" class="btn-view">View Product Website</a></p>
                      </div>
                  </div>
              </div>
          <?php 
              } 
          }
          ?>
        </div>
        <div class="html2pdf__page-break">
        </div>
      </div>
  </div>
</div>

</body>
</html>