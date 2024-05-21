<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kop\y2sp\ScrollPager;
use yii\web\View;
use app\components\Cms;
use app\models\BrandDetails;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Occasions';
$this->params['breadcrumbs'][] = $this->title;
$web = Yii::getAlias('@web');
$isSearch = Cms::formShowHide("BrandSearch");
$totalRecords = BrandDetails::find()->where(['status' => 1])->count();

?>
<style type="text/css" media="screen">
    .table th a,
    .table th {
        color: #fff;
        font-size: 16px;
        font-weight: normal;

    }
</style>

<?php $this->beginBlock('headerblock') ?>
<div class="col-lg-8 col-sm-8"><a href="<?= Url::toRoute(['brands/index']); ?>" class="title-link">
        <h1><?= Html::encode($this->title) ?></h1>
    </a>


</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('searchblock') ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">List</a></li>
    </ol>
</nav>

<?php $this->endBlock() ?>

<div class="contents">
    <p id="record_count_text">Total active records <span id="record_count"><?= $searchModel->activeRecordsCounts ?></span></p>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table display', 'id' => 'DataTables'],
            //'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'columns' => [

                [
                    'attribute' => 'name',
                    'encodeLabel' => false,
                    'label' => 'Occasion Name',
                    'sortLinkOptions' => ['class' => 'sortable'],
                    'value' => function ($data) {
                        return $data->name;
                    }

                ],
                [
                    'attribute' => 'moment_name',
                    'encodeLabel' => false,
                    'label' => 'Moment Name',
                    'sortLinkOptions' => ['class' => 'sortable'],
                    'value' => function ($data) {
                        return $data->moment->name;
                    }

                ],
                [
                    'attribute' => 'updated_at',
                    'encodeLabel' => false,
                    'label' => 'Last Edited (EST)',
                    'sortLinkOptions' => ['class' => 'sortable'],
                    'format' => 'raw',
                    'value' => function ($data) {
                        //return ($data->updated_at!=null)?$data->updated_at:$data->created_at;
                        $update_time = ($data->updated_at != null) ? $data->updated_at : $data->created_at;
                        $date = new DateTime($update_time);
                        $date->setTimezone(Yii::$app->params['list_timezone']);
                        $first_name = isset($data->user->first_name) ? $data->user->first_name . ' ' : '';
                        $last_name = isset($data->user->last_name) ? $data->user->last_name : '';
                        $username = '<br/>' . $first_name . $last_name;
                        return $date->format(Yii::$app->params['date_time_format']) . $username;
                    }

                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'View',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model) {


                            $url = Url::toRoute(['occasion/view', 'id' => $model->id, 'type' => 'view']);
                            return Html::a('<i class="icon icon-view"></i"></i>', $url, [
                                'title' => Yii::t('app', 'View'),

                            ]);
                        },

                    ],
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
                'spinnerTemplate' => '<div class="ias-spinner" style="width:100%;margin-left:95%"><p><img src="' . Yii::$app->getUrlManager()->getBaseUrl() . '/assets/images/ajax-loader.gif' . '"  /><span style="margin-left:10px;">Load more</span></p> </div>',

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


</div>
</div>
<div class="text-center">
    <div class="dvloader" id="dvloader">Load more</div>
</div>

</div>

</div>
</div>