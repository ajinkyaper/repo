<?php

use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html charset=UTF-8">
        <title></title>  
    </head>
    <body style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;">
        <div class="diageo-container" style="background: rgb(204,204,204);">

            <table class="diageo-newsletter-table" cellpadding="0" cellspacing="0" border="0" width="640" align="center" style="background: rgb(255,255,255); font-family: 'Nunito Sans', sans-serif; font-size: 15px; color: rgb(25,36,58);">
                <thead>
                    <tr>
                        <th style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; background: rgb(232,231,236); text-align: center; padding: 20px;" align="center">
                            <img src="http://fhdtesting.in/diageo/web/img/header-logo.jpg" style="max-width: 100%;">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; padding: 50px; text-align: center; vertical-align: top;" align="center" valign="top">
                            <h4 style="font-family: 'Rubik', sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; word-break: normal; text-rendering: optimizelegibility; font-weight: normal; font-size: 18px; margin: 0 0 10px; line-height: 28px;">Thanks again for taking time to discover your drink today, we hope you enjoyed the conversation! Please see below for your persoanlized recommendation.</h4>
                            <h2 style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; word-break: normal; text-rendering: optimizelegibility; font-weight: 900; color: rgb(165,28,54); text-transform: uppercase; font-size: 18px; margin: 0 0 10px;">WE HOPE TO SEE YOU AGAIN SOON!</h2>
                        </td>
                    </tr>
                    <?php
                    $counter = 0;
                    foreach ($data as $product) {
                        ?>
                        <?php if ($counter % 2 == 0) { ?>
                            <tr>
                                <td style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; padding: 50px; text-align: center; vertical-align: top;" align="center" valign="top">
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="diageo-product-table">
                                        <tr>
                                            <td class="diageo-product-img" style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-align: center; vertical-align: top; padding: 0; padding-right: 20px; width: 180px;" width="180" align="center" valign="top">
                                                <img src="http://fhdtesting.in/diageo/web/<?php echo $product['pro_img']; ?>" style="max-width: 100%;">
                                            </td>
                                            <td class="diageo-product-data" style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; vertical-align: top; padding: 0; text-align: left;" valign="top" align="left">
                                                <h2 style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; word-break: normal; text-rendering: optimizelegibility; font-weight: 900; color: rgb(165,28,54); text-transform: uppercase; font-size: 18px; margin: 0 0 10px;">Crown Royal Blenders' mash</h2>
                                                <b>Description:</b>
                                                <p style="font-family: 'Rubik', sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; margin: 0 0 10px; line-height: 26px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                 <?php echo $product['pro_des']; ?>      
                                                </p>
                                                <!--                                                <b>Size Variants:</b>
                                                                                                        <p style="font-family: 'Rubik', sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; margin: 0 0 10px; line-height: 26px;">375 ml, 750 ml, 1 L</p>-->
                                                <table cellspacing="0" cellpadding="0" border="0">
                                                    <tr>
                                                        <td class="diageo-btn" style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-align: center; vertical-align: top; padding: 0; background: rgb(165, 28, 54); border: none; color: rgb(255,255,255); font-size: 18px; display: inline-block; margin: 5px 0; cursor: pointer; border-radius: 20px; moz-border-radius: 20px; khtml-border-radius: 20px; o-border-radius: 20px; webkit-border-radius: 20px; ms-border-radius: 20px;" align="center" valign="top">
                                                            <a href="<?php echo $product['des_url']; ?>" style="font-family: 'Nunito Sans', sans-serif; display: block; padding: 10px 0;">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo $product['cta'] ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <br>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <!-- For Adding Divider-->
        <!--                    <tr>
                                <td class="diageo-spacerDiv" style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-align: center; vertical-align: top; padding: 0 50px 50px;" align="center" valign="top">
                                    <div style="background: rgb(26,34,55); width: 240px; height: 2px; margin: auto;"></div>
                                </td>
                            </tr>-->
                        <?php } else { ?>
                            <!-- For Adding Divider-->
                            <tr>
                                <td style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; padding: 50px; text-align: center; vertical-align: top;" align="center" valign="top">
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="diageo-product-table">
                                        <tr class="alt">
                                            <td class="diageo-product-data" style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; vertical-align: top; padding: 0; text-align: right;" valign="top" align="right">
                                                <h2 style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; word-break: normal; text-rendering: optimizelegibility; font-weight: 900; color: rgb(165,28,54); text-transform: uppercase; font-size: 18px; margin: 0 0 10px;">Crown Royal Blenders' mash</h2>
                                                <b>Description:</b>
                                                <p style="font-family: 'Rubik', sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; margin: 0 0 10px; line-height: 26px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                    <?php echo $product['pro_des']; ?>    
                                                </p>
                                                <!--<b>Size Variants:</b>-->
                                                <!--<p style="font-family: 'Rubik', sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; margin: 0 0 10px; line-height: 26px;">375 ml, 750 ml, 1 L</p>-->
                                                <table cellspacing="0" cellpadding="0" border="0" align="right">
                                                    <tr>
                                                        <td class="diageo-btn" style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-align: center; vertical-align: top; padding: 0; background: rgb(165, 28, 54); border: none; color: rgb(255,255,255); font-size: 18px; display: inline-block; margin: 5px 0; cursor: pointer; border-radius: 20px; moz-border-radius: 20px; khtml-border-radius: 20px; o-border-radius: 20px; webkit-border-radius: 20px; ms-border-radius: 20px;" align="center" valign="top">
                                                            <a href="<?php echo $product['des_url']; ?>" style="font-family: 'Nunito Sans', sans-serif; display: block; padding: 10px 0;">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo $product['cta'] ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <br>
                                            </td>
                                            <td class="diageo-product-img" style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-align: center; vertical-align: top; padding: 0; width: 180px; padding-left: 20px; padding-right: 0;" width="180" align="center" valign="top">
                                                <img src="http://fhdtesting.in/diageo/web/<?php echo $product['pro_img']; ?>" style="max-width: 100%;">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        <?php } ?>
                        <!-- For Adding Divider-->
                        <tr>
                            <td class="diageo-spacerDiv" style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-align: center; vertical-align: top; padding: 0 50px 50px;" align="center" valign="top">
                                <div style="background: rgb(26,34,55); width: 240px; height: 2px; margin: auto;"></div>
                            </td>
                        </tr>

                        <?php
                        $counter++;
                    }
                    ?>
                    <!-- For Adding Divider-->
                </tbody>
                <tfoot style="margin: 50px 0 0; display: table;">
                    <tr>
                        <td style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; padding: 50px; vertical-align: top; background: rgb(232, 231, 236); text-align: center; font-size: 14px; color: rgb(26,35,52);" valign="top" align="center">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. <br> <br>
                            <div class="diageo-footer-links" style="list-style: none; text-align: center;">
                                <a href="#" style="border: 1px solid rgb(26,35,52); border-left: 0; border-top: 0; border-bottom: 0; display: inline-block; margin: 0 10px 0 0; padding: 0 10px 0 0; text-decoration: none; color: rgb(26,35,52); line-height: 12px;">About Diagio</a>
                                <a href="#" style="border: 1px solid rgb(26,35,52); border-left: 0; border-top: 0; border-bottom: 0; display: inline-block; margin: 0 10px 0 0; padding: 0 10px 0 0; text-decoration: none; color: rgb(26,35,52); line-height: 12px;">Privacy Policy</a>
                                <a href="#" style="border-left: 0; border-top: 0; border-bottom: 0; display: inline-block; margin: 0 10px 0 0; padding: 0 10px 0 0; text-decoration: none; color: rgb(26,35,52); line-height: 12px; border: none;">Terms &amp; Conditions</a>
                            </div>
                            <div class="diageo-social-icons" style="text-align: center; font-size: 0;">
                                <a href="#" style="display: inline-block; margin: 0 2px;">
                                    <img src="http://fhdtesting.in/diageo/web/img/twitter-icon.png" alt="" title="twitter" style="max-width: 100%;">
                                </a>
                                <a href="#" style="display: inline-block; margin: 0 2px;">
                                    <img src="http://fhdtesting.in/diageo/web/img/instagram-icon.png" alt="" title="instagram" style="max-width: 100%;">
                                </a>
                                <a href="#" style="display: inline-block; margin: 0 2px;">
                                    <img src="http://fhdtesting.in/diageo/web/img/facebook-icon.png" alt="" title="facebook" style="max-width: 100%;">
                                </a>
<!--                                <a href="#" style="display: inline-block; margin: 0 2px;">
                                    <img src="<?php //echo Url::toRoute('trackmail/index', ['uid' => 40, 'edu_id' => 1]); ?>" alt="" title="facebook" style="max-width: 100%;">
                                </a>-->

                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </body>
</html>
