<?php

use yii\helpers\Url;

$baseUrl = Url::base(true);
$assets = $baseUrl . '/assets/';
$images = $assets . 'images/';
$js = $assets . 'js/';
$css = $assets . 'css/';

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
    <title>Discover a drink enhancement</title>
    <link href="<?= $css; ?>bootstrap.min.css" rel="stylesheet">
    <link href="<?= $css; ?>helper.css" rel="stylesheet">
    <link href="<?= $css; ?>styles.css" rel="stylesheet">
    <link href="<?= $css; ?>styles_new.css" rel="stylesheet">
    <script src="<?= $js; ?>jquery.min.js"></script>
    <script src="<?= $js; ?>bootstrap.min.js"></script>
    <link rel="icon" type="image/x-icon" href="<?= Url::base() . '/favicon.ico' ?>">
    <style type="text/css">
        #print_part .logo-img-grid {
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #E8E8E8;
        }

        #print_part .blue-grid-txt {
            /*height: 818px;*/
        }

        #print_part .blue-grid-txt p {
            /*padding: 320px 100px 0;*/
            padding: 60px 100px;
        }

        #print_part .top-pdf-section {
            margin-bottom: 30px;
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

        #print_part .product-details-grid h2 {}

        #print_part .products h5 span {
            background: #e9e8e7;
        }

        html,
        body {
            background-color: #e9e8e7;
            -webkit-print-color-adjust: exact;
            page-break-inside: avoid;
        }

        @media print {
            .products {
                page-break-inside: avoid;


            }

            ul {
                page-break-inside: avoid;
            }

            li {
                /*line-height: 22px;*/
                /*page-break-after: avoid;*/
                /*padding-bottom: 10px;*/
                page-break-inside: avoid;
            }
        }


        li:last-child {
            padding: 0;
        }


        .html2pdf__page-break {
            page-break-before: always;
        }
    </style>
</head>

<body class="consumer html-content" id="content">
    <!-- <div style="position: absolute;top: 0;left: 0;right: 0;bottom: 0;width: 100%;height: 100%;background: red;margin: auto;"></div> -->
    <div id="print_part">
        <div id="no_use" class="top-pdf-section">
            <div class="logo-img-grid">
                <img src="<?= $images ?>banner-cr.jpg" alt="" class="img-responsive">
            </div>
            <div class="dmdd">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 blue-grid-txt">
                            <p>Thanks again for taking the time to discover a new favorite. We heard what you’re looking for and we’ve curated the perfect collection of personalized recommendations that we’re sure you’re going to love. So, grab a glass and enjoy.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="products" style="background-color: #e9e8e7;">
            <div class="container">
                <div>
                    <?php $count = 0; ?>
                    <?php $i = -1;
                    $k = -2;
                    foreach ($data as $key => $value) {
                        // if($count % 2 ==0) {
                        //    echo "<div class='row'>";
                        // }
                    ?>

                        <?php if ($value['cocktail_name'] != '') {
                            $i = $i + 1;
                            $k = $k + 1;
                            $count += 1; ?>
                            <div style="float:left;width:49%;" class="section <?php echo $cond = $i == count($data) ? 'html2pdf__page-break' : ''; ?>">
                                <div class="product-details-grid" style="margin-top: 60px;">
                                    <div style="width:30%; float:left;" class="product-img text-center">
                                        <img src="<?php echo $cocktail_base_path . $value['cocktail_image'] ?>" class="img-responsive" alt="" style="max-height: 300px;" />
                                    </div>
                                    <div style="width:69%; float:left;vertical-align: top;" class="product-details">
                                        <div style="page-break-inside: avoid;">
                                            <h2>
                                                <?php echo $value['cocktail_name'] ?>
                                            </h2>
                                            <h5><span>Description</span></h5>
                                        </div>
                                        <div style=""><?php echo $value['ingredients'] ?></div>
                                        <h5><span>Cocktail Instructions</span></h5>
                                        <div style=""><?php echo $value['instructions'] ?></div>
                                        <p style=" margin-top: 40px;"><a href="<?= $value['cocktail_url'] ?>" target="_blank" class="btn-view">View Product Website</a></p>
                                    </div>
                                    <div style="clear:both;"></div>
                                </div>
                            </div>
                        <?php } else {
                            $i = $i + 1;
                            $k = $k + 1;
                            $count += 1; ?>
                            <div style="float:left;width:49%;" class="section <?php echo $cond =  $i == count($data) ? 'html2pdf__page-break' : ''; ?>">
                                <div class="product-details-grid" style="margin-top: 60px;">
                                    <div style="width:30%; float:left;" class="product-img text-center">
                                        <img src="<?php echo $marque_base_path . $value['marque_image'] ?>" class="img-responsive" style="max-height: 300px;" alt="" />
                                    </div>
                                    <div style="width:65%; float:left;vertical-align: top;" class="product-details">
                                        <div style="page-break-inside: avoid;">
                                            <h2>
                                                <?= $value['marque_name'] ?>
                                            </h2>
                                            <h5><span>Description</span></h5>
                                        </div>
                                        <div style=""><?= $value['description'] ?></div>
                                        <p style=" margin-top: 40px;"><a href="<?= $value['marque_url'] ?>" target="_blank" class="btn-view">View Product Website</a></p>
                                    </div>
                                    <div style="clear:both;"></div>
                                </div>
                            </div>
                    <?php
                        }
                        if ($count % 2 == 0) {
                            echo "<div style='clear:both;'></div>";
                        }
                    }
                    ?>
                </div>
                <div style='clear:both;'></div>
                <div class="html2pdf__page-break" style="background-color: #e9e8e7;">
                </div>
            </div>
        </div>
    </div>
</body>

</html>