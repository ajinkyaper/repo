<?php

use yii\helpers\Url;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8">
    <title></title>
    <!--                <style type="text/css">
                    @media only screen and (max-width:600px) {
                        table.diageo-newsletter-table td.diageo-spacerDiv {
                            padding: 0 50px;
                        }

                        table td,
                        table {
                            display: block !important;
                            width: 100% !important;
                            text-align: center !important;
                        }

                        table.diageo-newsletter-table table.diageo-product-table td.diageo-product-img {
                            padding: 30px 0 0 !important;
                        }
                    }
                </style>-->
</head>

<body style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;">
    <div class="diageo-container" style="background: rgb(204, 204, 204); min-width: 640px;">
        <table class="diageo-newsletter-table" cellpadding="0" cellspacing="0" border="0" align="center" width="640" style="background: rgb(255, 255, 255); font-family: 'Nunito Sans', sans-serif; font-size: 15px; color: rgb(25, 36, 58); width: 640px;">
            <thead>
                <tr>
                    <th style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; background: rgb(232, 231, 236); text-align: center; padding: 20px;" align="center">
                        <img src="https://discoveradrink.com/web/img/header-logo.jpg" style="max-width: 100%;">
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; padding: 50px 30px; text-align: center; vertical-align: top;" align="center" valign="top">
                        <h4 style="font-family: 'Rubik', sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; word-break: normal; text-rendering: optimizelegibility; font-weight: normal; font-size: 18px; margin: 0 0 10px; line-height: 28px;">Thanks again for taking time to discover your drink today, we hope you enjoyed the conversation! Please see below for your personalized recommendation.</h4>
                        <h2 style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; word-break: normal; text-rendering: optimizelegibility; font-weight: 900; color: rgb(165, 28, 54); text-transform: uppercase; font-size: 18px; margin: 0 0 10px;">WE HOPE TO SEE YOU AGAIN SOON!</h2>
                    </td>
                </tr>
                <?php
                $counter = 0;
                foreach ($data as $product) {
                ?>
                    <?php if ($counter % 2 == 0) {
                        $pro_id = $product['pro_id']; ?>
                        <tr>
                            <td style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; padding: 50px 30px; text-align: center; vertical-align: top;" align="center" valign="top">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%" class="diageo-product-table">
                                    <tr>
                                        <td class="diageo-product-img" width="150" style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-align: center; vertical-align: top; padding: 0; padding-right: 20px;" align="center" valign="top">
                                            <img src="https://discoveradrink.com/web/<?php echo $product['pro_img']; ?>" style="max-width: 100%; max-height: 300px; width: auto;">
                                        </td>
                                        <td class="diageo-product-data" style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; vertical-align: top; padding: 0; text-align: left;" valign="top" align="left">
                                            <h2 style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; word-break: normal; text-rendering: optimizelegibility; font-weight: 900; color: rgb(165, 28, 54); text-transform: uppercase; font-size: 18px; margin: 0 0 10px;"><?php echo $product['pro_name']; ?></h2>
                                            <b>Description:</b>
                                            <p style="font-family: 'Rubik', sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; margin: 0 0 10px; line-height: 26px;">
                                                <?php echo $product['pro_des']; ?></p>
                                            <table cellspacing="0" cellpadding="0" border="0">
                                                <tr>
                                                    <td class="diageo-btn" style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-align: center; vertical-align: top; background: rgb(165, 28, 54); border: none; color: rgb(255, 255, 255); font-size: 18px; display: inline-block; margin: 5px 0; padding: 0 20px; cursor: pointer; border-radius: 20px; moz-border-radius: 20px; khtml-border-radius: 20px; o-border-radius: 20px; webkit-border-radius: 20px; ms-border-radius: 20px;" align="center" valign="top">
                                                        <a href="<?php echo Url::toRoute("trackmail/viewtrack?proid=$pro_id&edu=$edu_id&urid=$user_random_id", true); ?>" style="color: rgb(255, 255, 255); font-family: 'Nunito Sans', sans-serif; padding: 10px 0; display: inline-block; font-weight: normal; text-decoration: none;">
                                                            <span style="text-decoration: none;"><?php echo $product['cta'] ?></span>
                                                        </a>
                                                        <?php //echo $product['des_url'];  
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    <?php } else { ?>
                        <!-- For Adding Divider-->
                        <!--                                <tr>
                                            <td style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; padding: 50px 30px; text-align: center; vertical-align: top;" align="center" valign="top">
                                                <table class="diageo-spacerDiv" cellpadding="0" cellspacing="0" align="center">
                                                    <tr>
                                                        <td style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-align: center; vertical-align: top; padding: 0; border-bottom: 2px solid rgb(26, 34, 55); width: 240px; margin: auto;" width="240" align="center" valign="top"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>-->
                        <!-- For Adding Divider-->
                        <tr>
                            <td style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; padding: 50px 30px; text-align: center; vertical-align: top;" align="center" valign="top">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%" class="diageo-product-table">
                                    <tr class="alt">
                                        <td class="diageo-product-data" style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; vertical-align: top; padding: 0; text-align: right;" valign="top" align="right">
                                            <h2 style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; word-break: normal; text-rendering: optimizelegibility; font-weight: 900; color: rgb(165, 28, 54); text-transform: uppercase; font-size: 18px; margin: 0 0 10px;"><?php echo $product['pro_name']; ?></h2>
                                            <b>Description:</b>
                                            <p style="font-family: 'Rubik', sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; margin: 0 0 10px; line-height: 26px;">
                                                <?php echo $product['pro_des']; ?> </p>
                                            <table cellspacing="0" cellpadding="0" border="0" align="right">
                                                <tr>
                                                    <td class="diageo-btn" style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-align: center; vertical-align: top; background: rgb(165, 28, 54); border: none; color: rgb(255, 255, 255); font-size: 18px; display: inline-block; margin: 5px 0; padding: 0 20px; cursor: pointer; border-radius: 20px; moz-border-radius: 20px; khtml-border-radius: 20px; o-border-radius: 20px; webkit-border-radius: 20px; ms-border-radius: 20px;" align="center" valign="top">
                                                        <a href="<?php echo Url::toRoute("trackmail/viewtrack?proid=$pro_id&edu=$edu_id&urid=$user_random_id", true); ?>" style="color: rgb(255, 255, 255); font-family: 'Nunito Sans', sans-serif; padding: 10px 0; display: inline-block; font-weight: normal; text-decoration: none;">
                                                            <span style="text-decoration: none;"><?php echo $product['cta'] ?></span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="diageo-product-img" width="150" style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-align: center; vertical-align: top; padding: 0; padding-left: 20px; padding-right: 0;" align="center" valign="top">
                                            <img src="https://discoveradrink.com/web/<?php echo $product['pro_img']; ?>" height="300" style="max-width: 100%; max-height: 300px; width: auto;">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    <?php } ?>
                    <!-- For Adding Divider-->
                    <tr>
                        <td style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; padding: 50px 30px; text-align: center; vertical-align: top;" align="center" valign="top">
                            <table class="diageo-spacerDiv" cellpadding="0" cellspacing="0" align="center">
                                <tr>
                                    <td style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-align: center; vertical-align: top; padding: 0; border-bottom: 2px solid rgb(26, 34, 55); width: 240px; margin: auto;" width="240" align="center" valign="top"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                <?php
                    $counter++;
                }
                ?>
                <!-- For Adding Divider-->
            </tbody>
            <tfoot style="margin: 0; display: table;">
                <tr>
                    <td style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; padding: 50px 30px; vertical-align: top; background: rgb(232, 231, 236); text-align: center; font-size: 14px; color: rgb(26, 35, 52);" valign="top" align="center">
                        Diageo is a global leader in beverage alcohol with an outstanding collection of brands across spirits and beer - a bussiness built on the principles and foundations laid by the giants of the industry. <br> <br>
                        <table class="diageo-footer-links" cellpadding="0" cellspacing="0" align="center" style="list-style: none; text-align: center;">
                            <tr>
                                <td style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; background: rgb(232, 231, 236); text-align: center; font-size: 14px; color: rgb(26, 35, 52); border-right: 1px solid rgb(26, 35, 52); padding: 0 8px; vertical-align: middle;" align="center" valign="middle">
                                    <a href="https://www.diageo.com/en/our-brands/brand-explorer/" target="_blank" style="display: block; color: rgb(26, 35, 52); line-height: 12px; text-decoration: none;">About Diagio</a>
                                </td>
                                <td style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; background: rgb(232, 231, 236); text-align: center; font-size: 14px; color: rgb(26, 35, 52); border-right: 1px solid rgb(26, 35, 52); padding: 0 8px; vertical-align: middle;" align="center" valign="middle">
                                    <a href="https://footer.diageohorizon.com/dfs/assets/www.diageo.com/PrivacyPolicy_en.html?locale=en-gb" target="_blank" style="display: block; color: rgb(26, 35, 52); line-height: 12px; text-decoration: none;">Privacy Policy</a>
                                </td>
                                <td style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; background: rgb(232, 231, 236); text-align: center; font-size: 14px; color: rgb(26, 35, 52); border-right: 1px solid rgb(26, 35, 52); padding: 0 8px; vertical-align: middle; border: none;" align="center" valign="middle">
                                    <a href="https://footer.diageohorizon.com/dfs/assets/www.diageo.com/PrivacyPolicy_en.html?locale=en-gb" target="_blank" style="display: block; color: rgb(26, 35, 52); line-height: 12px; text-decoration: none;">Terms &amp; Conditions</a>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <table class="diageo-social-icons" align="center" style="text-align: center; font-size: 0;">
                            <tr>
                                <td style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; vertical-align: top; background: rgb(232, 231, 236); text-align: center; font-size: 14px; color: rgb(26, 35, 52); padding: 0 2px;" valign="top" align="center">
                                    <a href="https://twitter.com/Diageo_News" target="_blank" style="text-decoration: none;">
                                        <img src="https://discoveradrink.com/web/img/instagram-icon.png" alt="" title="twitter" style="max-width: 100%;">
                                    </a>
                                </td>
                                <td style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; vertical-align: top; background: rgb(232, 231, 236); text-align: center; font-size: 14px; color: rgb(26, 35, 52); padding: 0 2px;" valign="top" align="center">
                                    <a href="https://www.instagram.com/diageo/" target="_blank" style="text-decoration: none;">
                                        <img src="https://discoveradrink.com/web/img/twitter-icon.png" alt="" title="instagram" style="max-width: 100%;">
                                    </a>
                                </td>
                                <td style="font-family: 'Rubik', sans-serif; line-height: 1.42857; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; vertical-align: top; background: rgb(232, 231, 236); text-align: center; font-size: 14px; color: rgb(26, 35, 52); padding: 0 2px;" valign="top" align="center">
                                    <a href="https://www.youtube.com/user/Diageo" target="_blank" style="text-decoration: none;">
                                        <img src="https://discoveradrink.com/web/img/youtube.png" alt="" title="youtube" style="max-width: 100%;">
                                    </a>
                                </td>
                                <a href="#" style="display: inline-block; margin: 0 2px;">
                                    <img src="<?php echo Url::toRoute("trackmail/index?uid=$user_random_id&edu_id=$edu_id", true); ?>" alt="" title="facebook" width="0px" height="0px" style="max-width: 100%;">
                                </a>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>