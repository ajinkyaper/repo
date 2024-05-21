
<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
    <meta content="width=device-width" name="viewport"/>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet"/>
    <style>
        *{
            margin: 0;
            padding: 0;
            line-height: 1.65;
            font-family: 'Source Sans Pro', sans-serif;
        }
        img { max-width: 100%; display: block; }
        body{
            background: #000;
        }
        .btn-email{
            border: 1px solid #F97050;
            background: #F97050;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 16px;
            
        }
        .btn-email a{
            color: #fff !important;
        }
    </style>
</head>
<body>
    <table border="0" cellpadding="0" cellspacing="0" class="main-wrapper" style="width: 570px !important; height: 100%; background: #fff; margin: auto;border-spacing: 0px;">
        <tbody>
            <tr>
                <td style="width:100%;">
                    <p>
                        <img alt="logo" src="<?= $logo ?>" style="text-align: center; float: left; padding: 35px 40px 25px;"/>
                    </p>
                </td>
            </tr>
            <tr>
                <td style="width:100%;">
                    <div style="padding: 0px 0px 30px 85px;">
                        <p style="font-size: 24px;">
                            Welcome to DIAGEO - Discover a Drink
                        </p>
                    </div>
                </td>
            </tr>
            
        <tr>
            <td>

                <p style="padding: 0px 95px 5px 85px;font-weight: 600;">
                    You have successfully registered with <b>DIAGEO - Discover a Drink.</b> Please use the below email to login to the app. An OTP will be later this email id for verification.
                </p>
                <p style="padding:0px 0px 5px 85px;">
                    <span style="font-weight: 600;">
                        Email:
                    </span>
                    <?php echo $email; ?>
                </p>

                <p style="padding:0px 0px 5px 85px;">
                    Thanks And Regards,
                </p>
                <p style="padding:0px 0px 70px 85px;font-weight: 600;">
                    DIAGEO - Discover a Drink.
                </p>
            </td>
        </tr>
        
</tbody>
</table>
</body>
</html>
