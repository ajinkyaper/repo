<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kop\y2sp\ScrollPager;
use yii\web\View;
use app\models\EducatorActivityTrack;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CocktailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Activity Logs';
$this->params['breadcrumbs'][] = $this->title;
$web = Yii::getAlias('@web');
$totalRecords = EducatorActivityTrack::find()->count();
?>

<?php $this->beginBlock('headerblock') ?>
<div class="col-lg-8 col-sm-4"><a href="<?= Url::toRoute(['marques/index']); ?>" class="title-link">
        <h1><?= Html::encode($this->title) ?></h1>
    </a></div>
<?php $this->endBlock() ?>



<!-- <div class="container-fluid"> -->


<div class="contents">
    <p id="record_count_text">Total records <span id="record_count"><?= $totalRecords ?></span></p>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table display', 'id' => 'DataTable'],
            //'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'columns' => [

                [
                    'attribute' => 'edu_name',
                    'encodeLabel' => false,
                    'label' => 'Educator Name',
                    'contentOptions' => ['style' => 'width: 15%;'],
                    'sortLinkOptions' => ['class' => 'sortable'],
                    'value' => function ($data) {
                        //var_dump($data->educators[0]->edu_name);
                        return $data->educators[0]->edu_name;
                    }

                ],
                [
                    'attribute' => 'activity',
                    'encodeLabel' => false,
                    'label' => 'Activity',
                    'contentOptions' => ['style' => 'width: 10%;'],
                    'sortLinkOptions' => ['class' => 'sortable'],
                    'value' => function ($data) {

                        return $data->activity;
                    }

                ],
                [
                    'attribute' => 'market',
                    'label' => 'Market',
                    'format' => 'raw',
                    'sortLinkOptions' => ['class' => 'sortable'],
                    'value' => function ($data) {
                        return $data->educators[0]->market->name;
                    }

                ],
                [
                    'attribute' => 'device_id',
                    'label' => 'Device Id',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width: 25%;text-align:center;'],
                    'headerOptions' => ['style' => 'text-align:center;'],
                    'value' => function ($data) {
                        return $data->device_id;
                    }

                ],
                [
                    'attribute' => 'pin_downloaded',
                    'label' => 'Pin Downloaded',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width: 15%;text-align:center;'],

                    'value' => function ($data) {
                        return $data->pin_downloaded;
                    }

                ],
                [
                    'attribute' => 'pin_returned',
                    'label' => 'Pin Returned',
                    'format' => 'raw',
                    //'sortLinkOptions' => [ 'class' => 'sortable' ],
                    'contentOptions' => ['style' => 'width: 15%;text-align:center;'],
                    'value' => function ($data) {
                        return $data->pin_returned;
                    }

                ],
                [
                    'attribute' => 'updated_at',
                    'encodeLabel' => false,
                    'sortLinkOptions' => ['class' => 'sortable'],
                    'contentOptions' => ['style' => 'width: 18%%;'],
                    'format' => 'raw',
                    'label' => 'Time Stamp <i class="fa fa-sort xs-pl-2" aria-hidden="false"></i>',
                    'value' => function ($data) {
                        $update_time = $data->created_at;
                        $date = new DateTime($update_time);

                        return $date->format(Yii::$app->params['date_time_format']);
                    }

                ],

            ],
            'pager' => [
                'class' => \kop\y2sp\ScrollPager::class,
                'container' => '.grid-view tbody',
                'item' => 'tr',
                'triggerText' => 'Load More',
                'noneLeftText' => '',
                'triggerOffset' => $dataProvider->totalCount / $dataProvider->pagination->pageSize,

                //'spinnerSrc' => Yii::$app->getUrlManager()->getBaseUrl() . '/images/loading.gif',

                //'spinnerSrc' => Yii::$app->getUrlManager()->getBaseUrl() . '/assets/images/loading.gif',

                'spinnerTemplate' => '<tr class="ias-spinner"><td colspan="7"><img src="' . Yii::$app->getUrlManager()->getBaseUrl() . '/assets/images/ajax-loader.gif' . '"/> <i>Load more</i></td></tr>',


                'enabledExtensions' => [
                    ScrollPager::EXTENSION_TRIGGER,
                    ScrollPager::EXTENSION_PAGING,
                    ScrollPager::EXTENSION_NONE_LEFT,
                    ScrollPager::EXTENSION_SPINNER
                ],
                'paginationSelector' => '.grid-view .pagination',
            ],
        ]); ?>
    </div>
</div>
<div class="text-center">
    <div class="dvloader" id="dvloader">Load more</div>
</div>
<!-- </div> -->