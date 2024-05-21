<?php

use yii\helpers\Url;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
    <title>Document</title>
    <style type="text/css">
        .diageo-body {
            font-family: Arial;
            color: #222222;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p {
            margin: 0;
            padding: 0;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            mso-line-height-rule: exactly;
        }

        P {
            font-family: Arial;
            font-size: 13.5px;
            line-height: 24px;
            color: #484848;
            letter-spacing: .43px;
        }




        .diageo-body a {
            text-decoration: none;
        }

        img {
            max-width: 100%;
        }


        .hdr {
            width: 100%;
        }

        @media only screen and (max-width: 600px) {

            .hdr {
                width: 100% !important;
                background: #e8e7ec;
            }

            .footerContnt td a {
                font-size: 10px !important;
            }

        }
    </style>
</head>

<body class="diageo-body" style="margin:0px; padding:0px; mso-line-height-rule:exactly;" bgcolor="#ffffff">

    <table align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" width="640" style="width:640px;background:#ffffff;border:1px solid #e8e7ec;">
        <tr>
            <td width="100%">
                <table align="center" cellspacing="0" width="100%" cellpadding="0" border="0" class="hdr">
                    <tr>
                        <td width="100%" bgcolor="#e8e7ec" align="center" style="padding:10px 0;background:#e8e7ec">
                            <img src="<?php echo Url::toRoute("/trackmail/index?uid=$user_random_id&edu_id=$edu_id", true); ?>" alt="Diageo" title="Diageo" width="130" style="width:130px;" />
                        </td>
                    </tr>
                </table>

                <table align="center" cellspacing="0" cellpadding="0" border="0" width="100%" style="width:100%;margin-top:10px;">
                    <tr>
                        <td align="center" style="padding:20px 0">
                            <h5 style="font-weight: normal;font-size:19px;margin:10px 0;line-height:29px;color:#535353;width:85%">
                                Thanks again for taking time to discover your drink today, we hope you enjoyed the
                                conversation! Please see below for your personalized recommendation.</h5>
                            <h2 style="font-family:Arial;font-weight:bold;font-size:22px;margin: 0 0 10px;line-height:28px;color: #a51c36;line-height:30px;letter-spacing:0;margin-top:12px;">
                                WE HOPE TO SEE YOU AGAIN SOON!</h2>
                        </td>
                    </tr>
                </table>
                <?php
                $counter = 0;

                foreach ($data as $product) {
                    $pro_id = $product['data']->id;
                    if ($product['type'] == "cocktail") {
                        $pro_image = Yii::$app->urlManager->createAbsoluteUrl('/') . 'uploads/cocktail/' . $product['data']->image;
                        $product_name = $product['data']->marques->brand->brand_name . " " . $product['data']->name;
                    } elseif ($product['type'] == "marque") {
                        $pro_image = Yii::$app->urlManager->createAbsoluteUrl('/') . 'uploads/marques/' . $product['data']->image;
                        $product_name = $product['data']->brand->brand_name . " " . $product['data']->name;
                    }
                ?>

                    <?php
                    if ($counter % 2 == 0) {
                    ?>
                        <table align="center" cellspacing="0" cellpadding="0" border="0" width="100%" style="width:100%;margin-top:20px;">
                            <tr>
                                <td width="240" align="center">
                                    <img src="<?php echo $pro_image; ?>" alt="Diageo" title="Diageo" height="250" />
                                </td>
                                <td width="400" style="padding-right:35px;">
                                    <h2 style="font-family:Arial;font-weight:bold;font-size:22px;margin:10px 0 5px 0;line-height:28px;color: #a51c36;line-height:30px;letter-spacing:0;margin-top:12px;text-transform: uppercase;">
                                        <?php echo $product_name; ?></h2>

                                    <?php if ($product['type'] == "marque") { ?>
                                        <b style="font-size:15px">Description:</b>
                                    <?php } ?>
                                    <p style="font-family:Arial;font-size:15px;line-height:25px">
                                        <?php
                                        if ($product['type'] == 'cocktail') {
                                            $desc = $product['data']->ingredients;
                                        } else {
                                            $desc = $product['data']->description;
                                        }
                                        $des1 = str_replace("<ul>", " ", $desc);
                                        $des2 = str_replace("</ul>", " ", $des1);
                                        $des3 = str_replace("<li>", " ", $des2);
                                        $des4 = str_replace("</li>", " <span style='font-size:16px;'> </span><br>", $des3);
                                        echo $des4;
                                        ?>
                                    </p>
                                    <?php if ($product['type'] == "cocktail") { ?>
                                        <p style="font-family:Arial;font-size:15px;line-height:25px">
                                            <?php
                                            $des1 = str_replace("<ul>", " ", $product['data']->instructions);
                                            $des2 = str_replace("</ul>", " ", $des1);
                                            $des3 = str_replace("<li>", " ", $des2);
                                            $des4 = str_replace("</li>", " <span style='font-size:16px;'> </span><br>", $des3);
                                            echo $des4;
                                            ?>
                                        </p>
                                    <?php } ?>

                                    <table align="left" cellspacing="0" cellpadding="0" border="0" style="text-decoration: none;border: none;color: #ffffff;font-size:16px;margin: 5px 0;padding: 0 20px;cursor: pointer;border-radius: 20px;-moz-border-radius: 20px;-khtml-border-radius: 20px;-o-border-radius: 20px;-webkit-border-radius: 20px;-ms-border-radius: 20px;">
                                        <tr>
                                            <td height="36" style="padding:0"><a href="<?php echo Url::toRoute(['/trackmail/viewtrack', 'proid' => $pro_id, 'type' => $product['type'], 'edu' => $edu_id, 'urid' => $user_random_id], true); ?>" style="color: #ffffff;font-weight:bold !important;text-decoration: none;text-decoration: none !important;text-transform:uppercase;font-size:13.75px;font-family:Arial; padding: 15px 0;border-radius: 20px;-moz-border-radius: 20px;-khtml-border-radius: 20px;-o-border-radius: 20px;-webkit-border-radius: 20px;-ms-border-radius: 20px;">
                                                    <?php
                                                    $ctaBtnImg = Yii::$app->urlManager->createAbsoluteUrl('/') . 'img/vd.png';
                                                    ?>
                                                    <img src="<?php echo $ctaBtnImg; ?>" />
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <hr style="width:280px;border:none;border-bottom:2px solid #333333;background-color:none;margin-top:35px;margin-bottom:30px;" />
                                </td>
                            </tr>
                        </table>
                    <?php } else { ?>
                        <table align="center" cellspacing="0" cellpadding="0" border="0" width="100%" style="width:100%;margin-top:20px;">
                            <tr>
                                <td width="400" style="padding-left:45px;" align="right">
                                    <h2 style="font-family:Arial;font-weight:bold;font-size:22px;margin:10px 0 5px 0;line-height:28px;color: #a51c36;line-height:30px;letter-spacing:0;margin-top:12px;text-transform: uppercase;">
                                        <?php echo $product_name; ?></h2>
                                    <?php if ($product['type'] == "marque") { ?>
                                        <b style="font-size:15px">Description:</b>
                                    <?php } ?>
                                    <p style="font-family:Arial;font-size:15px;line-height:25px">
                                        <?php
                                        if ($product['type'] == 'cocktail') {
                                            $desc = $product['data']->ingredients;
                                        } else {
                                            $desc = $product['data']->description;
                                        }
                                        $des1 = str_replace("<ul>", " ", $desc);
                                        $des2 = str_replace("</ul>", " ", $des1);
                                        $des3 = str_replace("<li>", " ", $des2);
                                        $des4 = str_replace("</li>", " <span style='font-size:16px;'> </span><br>", $des3);
                                        echo $des4;
                                        ?>
                                    </p>
                                    <?php if ($product['type'] == "cocktail") { ?>
                                        <p style="font-family:Arial;font-size:15px;line-height:25px">
                                            <?php
                                            $des1 = str_replace("<ul>", " ", $product['data']->instructions);
                                            $des2 = str_replace("</ul>", " ", $des1);
                                            $des3 = str_replace("<li>", " ", $des2);
                                            $des4 = str_replace("</li>", " <span style='font-size:16px;'> </span><br>", $des3);
                                            echo $des4;
                                            ?>
                                        </p>
                                    <?php }

                                    ?>

                                    <table align="right" cellspacing="0" cellpadding="0" border="0" style="text-decoration: none;border: none;color: #ffffff;font-size:16px;margin: 5px 0;padding: 0 20px;cursor: pointer;border-radius: 20px;-moz-border-radius: 20px;-khtml-border-radius: 20px;-o-border-radius: 20px;-webkit-border-radius: 20px;-ms-border-radius: 20px;">
                                        <tr>
                                            <td height="36" style="padding:0">
                                                <a href="<?php echo Url::toRoute(['trackmail/viewtrack', 'proid' => $pro_id, 'type' => $product['type'], 'edu' => $edu_id, 'urid' => $user_random_id], true); ?>" style="color: #ffffff;font-weight: bold !important;text-decoration: none;text-transform:uppercase;font-size:13.75px;font-family:Arial;text-decoration: none !important;padding: 15px 0;border-radius: 20px;-moz-border-radius: 20px;-khtml-border-radius: 20px;-o-border-radius: 20px;-webkit-border-radius: 20px;-ms-border-radius: 20px;">
                                                    <?php
                                                    $ctaBtnImg = Yii::$app->urlManager->createAbsoluteUrl('/') . 'img/vd.png';
                                                    ?>
                                                    <img src="<?php echo $ctaBtnImg; ?>" />
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                                <td width="240" align="center">
                                    <img src="<?php echo $pro_image; ?>" alt="Diageo" title="Diageo" height="250" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <hr style="width:280px;border:none;border-bottom:2px solid #333333;background-color:none;margin-top:35px;margin-bottom:30px;" />
                                </td>
                            </tr>
                        </table>
                    <?php } ?>
                <?php
                    $counter++;
                }
                ?>
                <table align="center" cellspacing="0" cellpadding="0" bgcolor="#e8e7ec" border="0" width="100%" style="width:100%;background-color:#e8e7ec;">
                    <tr>
                        <td align="center" style="padding:25px">
                            <p style="font-family:Roboto;font-size:13px;line-height:20px;color:#1b2237;letter-spacing:.8px;text-align:center;margin-bottom:10px">Please drink responsibly.</p>
                            <p style="font-family:Roboto;font-size:13px;line-height:20px;color:#1b2237;letter-spacing:.8px">Diageo is a global leader in beverage alcohol with an outstanding collection of brands across spirits and beer - a bussiness built on the principles and foundations laid by the giants of the industry.</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table align="center" cellspacing="0" cellpadding="0" border="0" width="65%" class="footerContnt" style="width:65%;">
                                <tr>
                                    <td width="32.333%" align="center">
                                        <a href="https://www.diageo.com/en/our-brands/brand-explorer/" target="_blank" style="color:#333333;font-size:14px;">About Diagio</a>
                                    </td>
                                    <td width="1%" align="center" style="border-right:2px solid #333333"></td>
                                    <td width="32.333%" align="center">
                                        <a href="https://footer.diageohorizon.com/dfs/assets/www.diageo.com/PrivacyPolicy_en.html?locale=en-gb" target="_blank" style="color:#333333;font-size:14px;">Privacy Policy</a>
                                    </td>
                                    <td width="1%" align="center" style="border-left:2px solid #333333"></td>
                                    <td width="32.333%" align="right" style=" padding-left: 5px;">
                                        <a href="https://footer.diageohorizon.com/dfs/assets/www.diageo.com/PrivacyPolicy_en.html?locale=en-gb" target="_blank" style="color:#333333;font-size:14px;">Terms &amp; Conditions</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5" align="center">
                                        <a href="https://twitter.com/Diageo_News" target="_blank"> <img src="https://discoveradrink.com/web/img/twitter-icon.png" /> </a>
                                        <a href="https://www.instagram.com/diageo/" target="_blank"> <img src="https://discoveradrink.com/web/img/instagram-icon.png" /> </a>
                                        <a href="https://www.youtube.com/user/Diageo" target="_blank"> <img src="https://discoveradrink.com/web/img/youtube.png" /> </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
</body>

</html>