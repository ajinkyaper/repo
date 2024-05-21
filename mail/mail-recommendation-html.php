<?php

use yii\helpers\Url;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
</head>
<body>
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap');
		@import url('https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap');
		@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;800;900&display=swap');
		table {
			font-family: 'Tenor Sans', sans-serif;
		}
	</style>
	<div>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="background-color: #e9e8e7;">
			<tr>
				<td>
					<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="border: 1px solid #ececec;padding: 30px;">
						<tr>
							<td colspan="3" height="50">
							</td>
						</tr>
						<tr>
							<td width="25%">
								<div style="background:#000000;width: 100%;height: 1px;">								
								</div>
							</td>
							<td  align="center" width="20%">
								<img src="<?php echo Url::toRoute("/trackmail/index?uid=$user_random_id&edu_id=$edu_id", true); ?>" style="max-width: 100%" />
							</td>
							<td width="25%">
								<div style="background:#000000;width: 100%;height: 1px;">								
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="3" height="50">
							</td>
						</tr>
						<tr>
							<td align="center" colspan="3">
								<img src="<?= $logo ?>" style="max-width: 100%"  />
							</td>
						</tr>
						<tr>
							<td align="center" colspan="3">
								<p style="line-height: 29px;margin: 40px 0;font-size: 18px; letter-spacing: 2px;">
									<strong>Thanks again for taking the time to discover a new favorite. We heard what you’re looking for and we’ve curated the perfect collection of personalized recommendations that we’re sure you’re going to love.  So, grab a glass and enjoy.</strong>
								</p>				
							</td>
						</tr>
						<tr>
							<td colspan="3" height="50">
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<?php
                                    $counter = 0;

                                    foreach ($data as $product) {
                                        $pro_id = $product['data']->id;
                                        if ($product['type'] == "cocktail") {
                                            $pro_image = Yii::$app->urlManager->createAbsoluteUrl('/').'uploads/cocktail/'.$product['data']->image;
                                            $product_name = $product['data']->marques->brand->brand_name . " " . $product['data']->name;
                                        } elseif ($product['type'] == "marque") {
                                            $pro_image = Yii::$app->urlManager->createAbsoluteUrl('/').'uploads/marques/'.$product['data']->image;
                                            $product_name = $product['data']->brand->brand_name . " " . $product['data']->name;
                                        }

                                    if ($product['type'] == 'cocktail') {
                                        $desc = $product['data']->ingredients;
                                    } else {
                                        $desc = $product['data']->description;
                                    }
                                ?>
								<div style="max-width: 500px; margin: 0 auto 80px;">
									<table cellpadding="0" cellspacing="0" border="0" width="100%">
										<tr>
											<td style="font-family: 'Playfair Display', serif;font-size: 30px;vertical-align: bottom;" width="260">
												<?= $product_name ?>
											</td>
											<td align="right">
												<div style="margin: auto;text-align: center;">
													<img src="<?= $pro_image ?>" height="200" alt="">										
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="2" height="20">
											</td>
										</tr>
									</table>
									<table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family: 'Nunito', sans-serif;">
										<tr>
											<td width="100">
												<p style="margin: 0 10px 0 0;font-size: 17px; letter-spacing: 2px; font-weight: 900;">
													Description
												</p>
											</td>
											<td>
												<div style="border-bottom: 1px solid #000000;margin-bottom: 20px;">
													&nbsp;
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-weight: 600;">
												<p style="font-size: 15px;margin: 0;letter-spacing:2px;line-height: 22px;">
													<?= $desc ?>
												</p>
												<a href="<?php echo Url::toRoute(['/trackmail/viewtrack', 'proid'=>$pro_id, 'type'=>$product['type'], 'edu'=>$edu_id,'urid'=>$user_random_id], true); ?>" style="padding: 15px; background-color: #e4ddc8;font-size: 13px;color: #000;text-decoration: none;font-weight: bold;margin: 20px 10px 0 0;display: inline-block;border:3px solid #000;border-left: none;border-top: none;">
													View Product Website
												</a>
												<!-- <a href="<?php echo Url::toRoute(['/consumer/'], true); ?>" style="padding: 15px; background-color: #e4ddc8;font-size: 13px;color: #000;text-decoration: none;font-weight: bold;margin: 20px 0 0 0;display: inline-block;border:3px solid #000;border-left: none;border-top: none;">
													Register for Virtual Tasting
												</a> -->
											</td>
										</tr>
									</table>						
								</div>
							<?php } ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>		
		</table>		
	</div>
</body>
</html>
