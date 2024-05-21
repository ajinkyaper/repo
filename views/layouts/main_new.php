<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\LayoutAsset;
use yii\helpers\Url;


LayoutAsset::register($this);

$assets = Yii::$app->assetManager->baseUrl . '/';
$images = $assets . 'images/';
$js = $assets . 'js/';

$first_name = isset(\Yii::$app->user->identity->first_name) ? \Yii::$app->user->identity->first_name . ' ' : '';
$last_name = isset(\Yii::$app->user->identity->last_name) ? \Yii::$app->user->identity->last_name : '';
$username = $first_name . $last_name;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php $this->registerCsrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<link rel="icon" type="image/x-icon" href="<?= Url::base() . '/favicon.ico' ?>">
	<?php $this->head() ?>
</head>

<body>
	<?php $this->beginBody() ?>
	<div class="d-flex wrapper">
		<!-- Sidebar -->
		<div id="sidebar">
			<div class="sidebar-heading"><a href="<?= Url::toRoute(['cocktail/index']); ?>" class="title-link"><img src="<?= $images; ?>logo.svg" alt="" /></a></div>
			<ul class="nav">
				<li><a href="<?php echo Url::toRoute(['cocktail/index']); ?>" class="<?php echo (Yii::$app->controller->id == "cocktail") ? 'active' : ''; ?>">Cocktails</a></li>
				<li><a href="<?php echo Url::toRoute(['marques/index']); ?>" class="<?php echo (Yii::$app->controller->id == "marques") ? 'active' : ''; ?>">Marques</a></li>
				<li><a class="<?php echo (Yii::$app->controller->id == "brands") ? 'active' : ''; ?>" href="<?php echo Url::toRoute(['brands/index']); ?>">Brands</a></li>
				<li><a class="<?php echo (Yii::$app->controller->id == "category") ? 'active' : ''; ?>" href="<?php echo Url::toRoute(['category/index']); ?>">Categories</a></li>

				<li><a href="<?= Url::to(['/occasion']) ?>" class="<?php echo (Yii::$app->controller->id == "occasion") ? 'active' : ''; ?>">Occasions</a></li>
				<li><a href="<?= Url::to(['/moment']) ?>" class="<?php echo (Yii::$app->controller->id == "moment") ? 'active' : ''; ?>">Moments</a></li>
				<li><a href="<?php echo Url::toRoute(['exportreport/index']); ?>" class="<?php echo (Yii::$app->controller->id == "exportreport") ? 'active' : ''; ?>">Reports</a></li>
				<li><a class="drop <?php echo (Yii::$app->controller->id == "settings" || Yii::$app->controller->id == "ipadusers" || Yii::$app->controller->id == "market" || Yii::$app->controller->id == "activity") ? 'active' : ''; ?>">Settings
						<!--<span class="icon plus"></span>-->
					</a>
					<div class=" <?php echo (Yii::$app->controller->id == "settings" || Yii::$app->controller->id == "ipadusers" || Yii::$app->controller->id == "market" || Yii::$app->controller->id == "activity") ? 'show' : ''; ?>">
						<ul>
							<li><a href="<?= Url::to(['settings/login-screen']) ?>" class="<?php echo (Yii::$app->controller->id == "settings") ? 'active' : ''; ?>">Login Screen</a></li>
							<li><a href="<?= Url::to(['/ipadusers']) ?>" class="<?php echo (Yii::$app->controller->id == "ipadusers") ? 'active' : ''; ?>">iPad User</a></li>
							<li><a href="<?php echo Url::toRoute(['market/index']); ?>" class="<?php echo (Yii::$app->controller->id == "market") ? 'active' : ''; ?>">Markets</a></li>
							<li><a href="<?php echo Url::toRoute(['activity/index']); ?>" class="<?php echo (Yii::$app->controller->id == "activity") ? 'active' : ''; ?> ">Activity Logs</a></li>
						</ul>
					</div>
				</li>


			</ul>
		</div>
		<!-- /#sidebar-wrapper -->

		<!-- Page Content -->
		<div class="page-content">

			<div class="container-fluid">
				<header>
					<div class="row">
						<?php
						if (isset($this->blocks['headerblock'])) {
							echo $this->blocks['headerblock'];
						}
						?>

						<div class="col-sm-4 text-right">
							<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
								<li class="nav-item">
									<div><label style="float: left;margin-left: 56%;"><?= $username ?></label>
										<?= Html::a(Html::img("@web/images/logout_icon_new.png", ['class' => '', 'style' => 'float:right;margin-top:1%', "height" => 20, "width" => 20]), ['/site/logout']); ?>
									</div>

									<!-- <a class="nav-link" href="#"><img src="assets/images/profile-icon.jpg" alt="" class="profile-icon">  </a> -->
								</li>
							</ul>
						</div>
					</div>
					<?php
					if (isset($this->blocks['searchblock'])) {
						echo $this->blocks['searchblock'];
					}
					?>
					<?php if (Yii::$app->session->hasFlash('success')) : ?>
						<div class="alert alert-success">
							<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

							<?= Yii::$app->session->getFlash('success') ?>
						</div>
					<?php endif; ?>

					<?php if (Yii::$app->session->hasFlash('error')) : ?>
						<div class="alert alert-danger alert-dismissable">
							<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

							<?= Yii::$app->session->getFlash('error') ?>
						</div>
					<?php endif; ?>
				</header>

				<?= $content ?>
			</div>

		</div>
		<!-- /#page-content-wrapper -->
	</div>
	<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>