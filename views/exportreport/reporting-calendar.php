<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Reporting Calendar';
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
    <div class="week-analysis-grid">
        <h2>Day of Week Analysis</h2>
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Sunday</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th class="highlight">Friday</th>
                    <th class="highlight">Saturday</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Engaged</td>
                    <td>21,835</td>
                    <td>21,835</td>
                    <td>21,835</td>
                    <td>21,835</td>
                    <td>21,835</td>
                    <td class="highlight">21,835</td>
                    <td class="highlight">21,835</td>
                </tr>
                <tr>
                    <td>Opt In Conversion Rate</td>
                    <td>8%</td>
                    <td>8%</td>
                    <td>8%</td>
                    <td>8%</td>
                    <td>8%</td>
                    <td class="highlight">8%</td>
                    <td class="highlight">8%</td>
                </tr>
                <tr>
                    <td>Speedrail Conversion Rate</td>
                    <td>50%</td>
                    <td>50%</td>
                    <td>50%</td>
                    <td>50%</td>
                    <td>50%</td>
                    <td class="highlight">50%</td>
                    <td class="highlight">50%</td>
                </tr>                
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td><a class="graph-trigger-btn" data-id="sunday-graph">Sunday<span></span></a></td>
                    <td><a class="graph-trigger-btn" data-id="monday-graph">Monday<span></span></a></td>
                    <td><a class="graph-trigger-btn" data-id="tuesday-graph">Tuesday<span></span></a></td>
                    <td><a class="graph-trigger-btn" data-id="wednesday-graph">Wednesday<span></span></a></td>
                    <td><a class="graph-trigger-btn" data-id="thursday-graph">Thursday<span></span></a></td>
                    <td><a class="graph-trigger-btn" data-id="friday-graph">Friday<span></span></a></td>
                    <td><a class="graph-trigger-btn" data-id="saturday-graph">Saturday<span></span></a></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="week-analysis-grid graphs">
        <div class="inner">
            <h2>Time of Day Analysis</h2>
            <div class="graph-container">
                <div id="sunday-graph" class="section">
                    Sunday
                   <?php
                        $series = [
                            [
                                'name' => 'Entity 1',
                                'data' => [
                                    ['2020-10-04', 5.66], ['2020-10-04', 2.0],
                                ],
                            ],
                            [
                                'name' => 'Entity 2',
                                'data' => [
                                    ['2020-10-04', 3.88], ['2020-10-05', 4.77],
                                ],
                            ],
                            [
                                'name' => 'Entity 3',
                                'data' => [
                                    ['2020-10-04', 5.40], ['2020-10-05', 6.0],
                                ],
                            ],
                            [
                                'name' => 'Entity 4',
                                'data' => [
                                    ['2020-10-04', 7.5], ['2020-10-05', 8.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 5',
                                'data' => [
                                    ['2020-10-04', 9.5], ['2020-10-05', 10.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 6',
                                'data' => [
                                    ['2020-10-04', 11.5], ['2020-10-05', 12.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 7',
                                'data' => [
                                    ['2020-10-04', 13.5], ['2020-10-05', 14.18],
                                ],
                            ],
                        ];

                        echo \onmotion\apexcharts\ApexchartsWidget::widget([
                            'type' => 'bar', // default area
                            'height' => '400', // default 350
                            'width' => '100%', // default 100%
                            'chartOptions' => [
                                'chart' => [
                                    'toolbar' => [
                                        'show' => false,
                                        'autoSelected' => 'zoom'
                                    ],
                                ],
                                'xaxis' => [
                                    'type' => 'datetime'
                                    // 'categories' => $categories,
                                ],
                                'plotOptions' => [
                                    'bar' => [
                                        'horizontal' => false,
                                        'columnWidth' => '40%',
                                        'distributed'=> false
                                    ],
                                ],
                                'dataLabels' => [
                                    'enabled' => true
                                ],
                                'legend' => [
                                    'verticalAlign' => 'bottom',
                                    'horizontalAlign' => 'left',
                                ],
                            ],
                            'series' => $series
                        ]);
                    ?>
                </div>
                <div id="monday-graph" class="section">
                    Monday
                    <?php
                        $series = [
                            [
                                'name' => 'Entity 1',
                                'data' => [
                                    ['2020-10-04', 5.66], ['2020-10-05', 2.0],
                                ],
                            ],
                            [
                                'name' => 'Entity 2',
                                'data' => [
                                    ['2020-10-04', 3.88], ['2020-10-05', 4.77],
                                ],
                            ],
                            [
                                'name' => 'Entity 3',
                                'data' => [
                                    ['2020-10-04', 5.40], ['2020-10-05', 6.0],
                                ],
                            ],
                            [
                                'name' => 'Entity 4',
                                'data' => [
                                    ['2020-10-04', 7.5], ['2020-10-05', 8.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 5',
                                'data' => [
                                    ['2020-10-04', 9.5], ['2020-10-05', 10.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 6',
                                'data' => [
                                    ['2020-10-04', 11.5], ['2020-10-05', 12.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 7',
                                'data' => [
                                    ['2020-10-04', 13.5], ['2020-10-05', 14.18],
                                ],
                            ],
                        ];

                        echo \onmotion\apexcharts\ApexchartsWidget::widget([
                            'type' => 'bar', // default area
                            'height' => '400', // default 350
                            'width' => '100%', // default 100%
                            'chartOptions' => [
                                'chart' => [
                                    'toolbar' => [
                                        'show' => false,
                                        'autoSelected' => 'zoom'
                                    ],
                                ],
                                'xaxis' => [
                                    'type' => 'datetime'
                                    // 'categories' => $categories,
                                ],
                                'plotOptions' => [
                                    'bar' => [
                                        'horizontal' => false,
                                        'columnWidth' => '40%',
                                        'distributed'=> false
                                    ],
                                ],
                                'dataLabels' => [
                                    'enabled' => true
                                ],
                                'legend' => [
                                    'verticalAlign' => 'bottom',
                                    'horizontalAlign' => 'left',
                                ],
                            ],
                            'series' => $series
                        ]);
                    ?>
                </div>
                <div id="tuesday-graph" class="section">
                    Tuesday
                    <?php
                        $series = [
                            [
                                'name' => 'Entity 1',
                                'data' => [
                                    ['2020-10-04', 5.66], ['2020-10-05', 2.0],
                                ],
                            ],
                            [
                                'name' => 'Entity 2',
                                'data' => [
                                    ['2020-10-04', 3.88], ['2020-10-05', 4.77],
                                ],
                            ],
                            [
                                'name' => 'Entity 3',
                                'data' => [
                                    ['2020-10-04', 5.40], ['2020-10-05', 6.0],
                                ],
                            ],
                            [
                                'name' => 'Entity 4',
                                'data' => [
                                    ['2020-10-04', 7.5], ['2020-10-05', 8.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 5',
                                'data' => [
                                    ['2020-10-04', 9.5], ['2020-10-05', 10.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 6',
                                'data' => [
                                    ['2020-10-04', 11.5], ['2020-10-05', 12.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 7',
                                'data' => [
                                    ['2020-10-04', 13.5], ['2020-10-05', 14.18],
                                ],
                            ],
                        ];

                        echo \onmotion\apexcharts\ApexchartsWidget::widget([
                            'type' => 'bar', // default area
                            'height' => '400', // default 350
                            'width' => '100%', // default 100%
                            'chartOptions' => [
                                'chart' => [
                                    'toolbar' => [
                                        'show' => false,
                                        'autoSelected' => 'zoom'
                                    ],
                                ],
                                'xaxis' => [
                                    'type' => 'datetime'
                                    // 'categories' => $categories,
                                ],
                                'plotOptions' => [
                                    'bar' => [
                                        'horizontal' => false,
                                        'columnWidth' => '40%',
                                        'distributed'=> false
                                    ],
                                ],
                                'dataLabels' => [
                                    'enabled' => true
                                ],
                                'legend' => [
                                    'verticalAlign' => 'bottom',
                                    'horizontalAlign' => 'left',
                                ],
                            ],
                            'series' => $series
                        ]);
                    ?>
                </div>
                <div id="wednesday-graph" class="section">
                    Wednesday
                    <?php
                        $series = [
                            [
                                'name' => 'Entity 1',
                                'data' => [
                                    ['2020-10-04', 5.66], ['2020-10-05', 2.0],
                                ],
                            ],
                            [
                                'name' => 'Entity 2',
                                'data' => [
                                    ['2020-10-04', 3.88], ['2020-10-05', 4.77],
                                ],
                            ],
                            [
                                'name' => 'Entity 3',
                                'data' => [
                                    ['2020-10-04', 5.40], ['2020-10-05', 6.0],
                                ],
                            ],
                            [
                                'name' => 'Entity 4',
                                'data' => [
                                    ['2020-10-04', 7.5], ['2020-10-05', 8.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 5',
                                'data' => [
                                    ['2020-10-04', 9.5], ['2020-10-05', 10.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 6',
                                'data' => [
                                    ['2020-10-04', 11.5], ['2020-10-05', 12.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 7',
                                'data' => [
                                    ['2020-10-04', 13.5], ['2020-10-05', 14.18],
                                ],
                            ],
                        ];

                        echo \onmotion\apexcharts\ApexchartsWidget::widget([
                            'type' => 'bar', // default area
                            'height' => '400', // default 350
                            'width' => '100%', // default 100%
                            'chartOptions' => [
                                'chart' => [
                                    'toolbar' => [
                                        'show' => false,
                                        'autoSelected' => 'zoom'
                                    ],
                                ],
                                'xaxis' => [
                                    'type' => 'datetime'
                                    // 'categories' => $categories,
                                ],
                                'plotOptions' => [
                                    'bar' => [
                                        'horizontal' => false,
                                        'columnWidth' => '40%',
                                        'distributed'=> false
                                    ],
                                ],
                                'dataLabels' => [
                                    'enabled' => true
                                ],
                                'legend' => [
                                    'verticalAlign' => 'bottom',
                                    'horizontalAlign' => 'left',
                                ],
                            ],
                            'series' => $series
                        ]);
                    ?>
                </div>
                <div id="thursday-graph" class="section">
                    Thursday
                    <?php
                        $series = [
                            [
                                'name' => 'Entity 1',
                                'data' => [
                                    ['2020-10-04', 5.66], ['2020-10-05', 2.0],
                                ],
                            ],
                            [
                                'name' => 'Entity 2',
                                'data' => [
                                    ['2020-10-04', 3.88], ['2020-10-05', 4.77],
                                ],
                            ],
                            [
                                'name' => 'Entity 3',
                                'data' => [
                                    ['2020-10-04', 5.40], ['2020-10-05', 6.0],
                                ],
                            ],
                            [
                                'name' => 'Entity 4',
                                'data' => [
                                    ['2020-10-04', 7.5], ['2020-10-05', 8.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 5',
                                'data' => [
                                    ['2020-10-04', 9.5], ['2020-10-05', 10.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 6',
                                'data' => [
                                    ['2020-10-04', 11.5], ['2020-10-05', 12.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 7',
                                'data' => [
                                    ['2020-10-04', 13.5], ['2020-10-05', 14.18],
                                ],
                            ],
                        ];

                        echo \onmotion\apexcharts\ApexchartsWidget::widget([
                            'type' => 'bar', // default area
                            'height' => '400', // default 350
                            'width' => '100%', // default 100%
                            'chartOptions' => [
                                'chart' => [
                                    'toolbar' => [
                                        'show' => false,
                                        'autoSelected' => 'zoom'
                                    ],
                                ],
                                'xaxis' => [
                                    'type' => 'datetime'
                                    // 'categories' => $categories,
                                ],
                                'plotOptions' => [
                                    'bar' => [
                                        'horizontal' => false,
                                        'columnWidth' => '40%',
                                        'distributed'=> false
                                    ],
                                ],
                                'dataLabels' => [
                                    'enabled' => true
                                ],
                                'legend' => [
                                    'verticalAlign' => 'bottom',
                                    'horizontalAlign' => 'left',
                                ],
                            ],
                            'series' => $series
                        ]);
                    ?>
                </div>
                <div id="friday-graph" class="section">
                    Friday
                    <?php
                        $series = [
                            [
                                'name' => 'Entity 1',
                                'data' => [
                                    ['2020-10-04', 5.66], ['2020-10-05', 2.0],
                                ],
                            ],
                            [
                                'name' => 'Entity 2',
                                'data' => [
                                    ['2020-10-04', 3.88], ['2020-10-05', 4.77],
                                ],
                            ],
                            [
                                'name' => 'Entity 3',
                                'data' => [
                                    ['2020-10-04', 5.40], ['2020-10-05', 6.0],
                                ],
                            ],
                            [
                                'name' => 'Entity 4',
                                'data' => [
                                    ['2020-10-04', 7.5], ['2020-10-05', 8.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 5',
                                'data' => [
                                    ['2020-10-04', 9.5], ['2020-10-05', 10.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 6',
                                'data' => [
                                    ['2020-10-04', 11.5], ['2020-10-05', 12.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 7',
                                'data' => [
                                    ['2020-10-04', 13.5], ['2020-10-05', 14.18],
                                ],
                            ],
                        ];

                        echo \onmotion\apexcharts\ApexchartsWidget::widget([
                            'type' => 'bar', // default area
                            'height' => '400', // default 350
                            'width' => '100%', // default 100%
                            'chartOptions' => [
                                'chart' => [
                                    'toolbar' => [
                                        'show' => false,
                                        'autoSelected' => 'zoom'
                                    ],
                                ],
                                'xaxis' => [
                                    'type' => 'datetime'
                                    // 'categories' => $categories,
                                ],
                                'plotOptions' => [
                                    'bar' => [
                                        'horizontal' => false,
                                        'columnWidth' => '40%',
                                        'distributed'=> false
                                    ],
                                ],
                                'dataLabels' => [
                                    'enabled' => true
                                ],
                                'legend' => [
                                    'verticalAlign' => 'bottom',
                                    'horizontalAlign' => 'left',
                                ],
                            ],
                            'series' => $series
                        ]);
                    ?>
                </div>
                <div id="saturday-graph" class="section">
                    Saturday
                    <?php
                        $series = [
                            [
                                'name' => 'Entity 1',
                                'data' => [
                                    ['2020-10-04', 5.66], ['2020-10-05', 2.0],
                                ],
                            ],
                            [
                                'name' => 'Entity 2',
                                'data' => [
                                    ['2020-10-04', 3.88], ['2020-10-05', 4.77],
                                ],
                            ],
                            [
                                'name' => 'Entity 3',
                                'data' => [
                                    ['2020-10-04', 5.40], ['2020-10-05', 6.0],
                                ],
                            ],
                            [
                                'name' => 'Entity 4',
                                'data' => [
                                    ['2020-10-04', 7.5], ['2020-10-05', 8.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 5',
                                'data' => [
                                    ['2020-10-04', 9.5], ['2020-10-05', 10.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 6',
                                'data' => [
                                    ['2020-10-04', 11.5], ['2020-10-05', 12.18],
                                ],
                            ],
                            [
                                'name' => 'Entity 7',
                                'data' => [
                                    ['2020-10-04', 13.5], ['2020-10-05', 14.18],
                                ],
                            ],
                        ];

                        echo \onmotion\apexcharts\ApexchartsWidget::widget([
                            'type' => 'bar', // default area
                            'height' => '400', // default 350
                            'width' => '100%', // default 100%
                            'chartOptions' => [
                                'chart' => [
                                    'toolbar' => [
                                        'show' => false,
                                        'autoSelected' => 'zoom'
                                    ],
                                ],
                                'xaxis' => [
                                    'type' => 'datetime'
                                    // 'categories' => $categories,
                                ],
                                'plotOptions' => [
                                    'bar' => [
                                        'horizontal' => false,
                                        'columnWidth' => '40%',
                                        'distributed'=> false
                                    ],
                                ],
                                'dataLabels' => [
                                    'enabled' => true
                                ],
                                'legend' => [
                                    'verticalAlign' => 'bottom',
                                    'horizontalAlign' => 'left',
                                ],
                            ],
                            'series' => $series
                        ]);
                    ?>
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