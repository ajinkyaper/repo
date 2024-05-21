<?php

use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
    <title></title>
</head>

<body>
    <div class="diageo-container">
        <style type="text/css">
            @import url('https://fonts.googleapis.com/css?family=Nunito+Sans:400,600,700,800,900&display=swap');

            .diageo-container {
                background-color: #cccccc;
            }

            table.diageo-newsletter-table {
                background: #ffffff;
                font-family: 'Nunito Sans', sans-serif;
                font-size: 15px;
                color: #19243a;
            }

            table.diageo-newsletter-table p {
                margin: 0 0 10px;
                line-height: 26px;
            }

            table.diageo-newsletter-table img {
                max-width: 100%;
            }

            table.diageo-newsletter-table h2 {
                font-weight: 900;
                color: #a51c36;
                text-transform: uppercase;
                font-size: 18px;
                margin: 0 0 10px;
            }

            table.diageo-newsletter-table h4 {
                font-weight: normal;
                font-size: 18px;
                margin: 0 0 10px;
                line-height: 28px;
            }

            table.diageo-newsletter-table th {
                background: #e8e7ec;
                text-align: center;
                padding: 20px;
            }

            table.diageo-newsletter-table td {
                padding: 50px;
                text-align: center;
                vertical-align: top;
            }

            table.diageo-newsletter-table td.diageo-spacerDiv {
                padding: 0 50px 50px;
            }

            table.diageo-newsletter-table td.diageo-spacerDiv>div {
                background-color: #1a2237;
                width: 240px;
                height: 2px;
                margin: auto;
            }

            table.diageo-newsletter-table table.diageo-product-table td {
                padding: 0;
            }

            table.diageo-newsletter-table table.diageo-product-table td.diageo-product-img {
                padding-right: 20px;
                width: 180px;
            }

            table.diageo-newsletter-table table.diageo-product-table td.diageo-product-data {
                text-align: left;
            }

            table.diageo-newsletter-table table.diageo-product-table tr.alt td.diageo-product-data {
                text-align: right;
            }

            table.diageo-newsletter-table table.diageo-product-table tr.alt td.diageo-product-img {
                padding-left: 20px;
                padding-right: 0;
            }

            table.diageo-newsletter-table table.diageo-product-table a.diageo-btn,
            table.diageo-newsletter-table table.diageo-product-table button.diageo-btn {
                background-color: #a51c36;
                font-family: 'Nunito Sans', sans-serif;
                border-radius: 20px;
                border: none;
                padding: 5px 20px;
                color: #ffffff;
                font-size: 18px;
                line-height: normal;
                display: inline-block;
                margin: 5px 0;
                cursor: pointer;
            }

            table.diageo-newsletter-table tfoot {
                background: #e8e7ec;
                margin: 50px 0 0;
                display: table;
            }

            table.diageo-newsletter-table tfoot td {
                text-align: center;
                font-size: 14px;
                color: #1a2334;
            }

            table.diageo-newsletter-table ul.diageo-footer-links li {
                border-right: 1px solid #1a2334;
                display: inline-block;
                padding: 0 10px;
            }

            table.diageo-newsletter-table ul.diageo-footer-links li a {
                text-decoration: none;
                color: #1a2334;
                line-height: 12px;
                display: block;
            }

            table.diageo-newsletter-table ul.diageo-footer-links li:last-child {
                border: none;
            }

            table.diageo-newsletter-table .diageo-social-icons {
                text-align: center;
            }

            table.diageo-newsletter-table .diageo-social-icons a {
                display: inline-block;
            }
        </style>
        <table class="diageo-newsletter-table" cellpadding="0" cellspacing="0" border="0" width="640" align="center">
            <img src="<?php echo Url::toRoute('trackmail/index', ['sub_id' => $req_id, 'edu_id' => $edu_id]); ?>" alt="test" width="1px" height="1px" />
            <thead>
                <tr>
                    <th>
                        <img src="https://discoveradrink.com/web/img/logo.png" />
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <h4>Thanks again for taking time to discover your drink today, we hope you enjoyed the conversation! Please see below for your persoanlized recommendation.</h4>
                        <h2>WE HOPE TO SEE YOU AGAIN SOON! </h2>
                    </td>
                </tr>
                <?php
                $counter = 0;
                foreach ($data as $product) {
                ?>
                    <?php if ($counter % 2 == 0) { ?>

                        <tr>
                            <td>
                                <table cellpadding="0" cellspacing="0" border="0" width="100%" class="diageo-product-table">
                                    <tr>
                                        <td class="diageo-product-img">
                                            <img src="https://discoveradrink.com/web/img/btl_01.png">
                                        </td>
                                        <td class="diageo-product-data">
                                            <h2>Crown Royal Blenders' mash</h2>
                                            <b>Description:</b>
                                            <p><?php echo $product['pro_des']; ?></p>
                                            <b>Size Variants:</b>
                                            <p>375 ml, 750 ml, 1 L</p>
                                            <button class="diageo-btn">View Details </button><br>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td>
                                <table cellpadding="0" cellspacing="0" border="0" width="100%" class="diageo-product-table">
                                    <tr class="alt">
                                        <td class="diageo-product-data">
                                            <h2>Crown Royal Blenders' mash</h2>
                                            <b>Description:</b>
                                            <p><?php echo $product['pro_des']; ?></p>
                                            <b>Size Variants:</b>
                                            <p>375 ml, 750 ml, 1 L</p>
                                            <button class="diageo-btn">View Details </button><br>
                                        </td>
                                        <td class="diageo-product-img">
                                            <img src="https://discoveradrink.com/web/img/btl_02.png">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    <?php } ?>



                    <!-- For Adding Divider-->
                    <tr>
                        <td class="diageo-spacerDiv">
                            <div></div>
                        </td>
                    </tr>
                <?php
                    $counter++;
                }
                ?>
                <!-- For Adding Divider-->

                <!-- For Adding Divider-->
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat.
                        <ul class="diageo-footer-links">
                            <li>
                                <a href="#">About Diagio</a>
                            </li>
                            <li>
                                <a href="#">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="#">Terms &amp; Conditions</a>
                            </li>
                        </ul>
                        <div class="diageo-social-icons">
                            <a href="#">
                                <img src="https://discoveradrink.com/web/img/ttr.png" alt="" title="twitter" />
                            </a>
                            <a href="#">
                                <img src="https://discoveradrink.com/web/img/insta.png" alt="" title="instagram" />
                            </a>
                            <a href="#">
                                <img src="https://discoveradrink.com/web/img/fb.png" alt="" title="facebook" />
                            </a>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>