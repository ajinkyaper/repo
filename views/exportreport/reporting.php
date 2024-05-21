<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Reporting';
$assets = Yii::$app->assetManager->baseUrl . '/';
$images = $assets . 'images/';
?>
<?php $this->beginBlock('headerblock') ?>
<div class="col-lg-8 col-sm-4"><a href="#" class="title-link">
        <h1>
            <?= Html::encode($this->title) ?>
        </h1>
    </a></div>
<?php $this->endBlock() ?>
<div class="reporting-page">
    <div class="count-bar">
        <div class="row">
            <div class="col">
                <h3>2,875</h3>
                <h6>Events Executed</h6>
            </div>
            <div class="col">
                <h3>8,843</h3>
                <h6>Consumers Engaged</h6>
            </div>
            <div class="col">
                <h3>608</h3>
                <h6>ENgaged Per Event</h6>
            </div>
            <div class="col">
                <h3>12,820</h3>
                <h6>Opt Ins</h6>
            </div>
            <div class="col">
                <h3>242,602</h3>
                <h6>Recommendations Made</h6>
            </div>
        </div>
    </div>
    <div class="top-section-grid">
        <h2>Top Moments</h2>
        <div class="row orange-bg">
            <div class="col">
                <div class="inner">
                    <img src="<?= $images; ?>reporting-top-section-dummy-img.png" />
                    <div class="data">
                        <h4>MWE - Indulgent Evening At Home</h4>
                        <p>
                            <span>1,023</span>
                            Customers Who Preferred
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="inner">
                    <img src="<?= $images; ?>reporting-top-section-dummy-img.png" />
                    <div class="data">
                        <h4>MWE - Indulgent Evening At Home</h4>
                        <p>
                            <span>1,023</span>
                            Customers Who Preferred
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="inner">
                    <img src="<?= $images; ?>reporting-top-section-dummy-img.png" />
                    <div class="data">
                        <h4>MWE - Indulgent Evening At Home</h4>
                        <p>
                            <span>1,023</span>
                            Customers Who Preferred
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="top-section-grid">
        <h2>Top Brands</h2>
        <div class="row">
            <div class="col">
                <div class="inner">
                    <img src="<?= $images; ?>baileys-dummy-img.png" width="100" />
                    <div class="data">
                        <p>
                            <span>1,023</span>
                            Recommendations
                        </p>
                        <p>
                            <span>1,023</span>
                            SpeedRail Adds
                        </p>
                        <p>
                            <span>1,023</span>
                            Speedrail Conversion Rate
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="inner">
                    <img src="<?= $images; ?>baileys-dummy-img.png" width="100" />
                    <div class="data">
                        <p>
                            <span>1,023</span>
                            Recommendations
                        </p>
                        <p>
                            <span>1,023</span>
                            SpeedRail Adds
                        </p>
                        <p>
                            <span>1,023</span>
                            Speedrail Conversion Rate
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="inner">
                    <img src="<?= $images; ?>baileys-dummy-img.png" width="100" />
                    <div class="data">
                        <p>
                            <span>1,023</span>
                            Recommendations
                        </p>
                        <p>
                            <span>1,023</span>
                            SpeedRail Adds
                        </p>
                        <p>
                            <span>1,023</span>
                            Speedrail Conversion Rate
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="brand-analysis-grid">
        <h2>Brand Analysis</h2>
        <div class="custom-accordion">
            <div class="acc-section">
                <div class="acc-heading">
                    Baileys
                    <span class="arrow"></span>
                </div>
                <div class="acc-content">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Varient</th>
                                <th>Moment</th>
                                <th>Recommendations</th>
                                <th>Speedrails Ads</th>
                                <th>Speedrail Conversion Rate</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            	<td rowspan="3" class="img-col">
                            		<img src="<?= $images; ?>baileys-dummy-img.png" width="100" />
                            	</td>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                            </tr> 
                                                     
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="acc-section">
                <div class="acc-heading">
                    Captain Morgan
                    <span class="arrow"></span>
                </div>
                <div class="acc-content">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Varient</th>
                                <th>Moment</th>
                                <th>Recommendations</th>
                                <th>Speedrails Ads</th>
                                <th>Speedrail Conversion Rate</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            	<td rowspan="3" class="img-col">
                            		<img src="<?= $images; ?>baileys-dummy-img.png" width="100" />
                            	</td>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                            </tr> 
                                                     
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>
<br>
<script>

</script>