<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kop\y2sp\ScrollPager;
use yii\web\View;
use app\models\Marques;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CocktailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Marques';
$this->params['breadcrumbs'][] = $this->title;
$web = Yii::getAlias('@web');
$totalRecords = Marques::find()->where(['status' => 1])->count();
?>

<?php $this->beginBlock('headerblock') ?>
<div class="col-lg-8 col-sm-8"><a href="<?= Url::toRoute(['marques/index']); ?>" class="title-link">
        <h1><?= Html::encode($this->title) ?></h1>
    </a>
    <ul class="nav">
        <li><a href="#" class="btn search">Search</a></li>
        <li><?= Html::a('Add New', ['create'], ['class' => 'btn add']) ?></li>
    </ul>

</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('searchblock') ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">List</a></li>
    </ol>
</nav>

<div class="search-box" id="search-box">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
</div>
<?php $this->endBlock() ?>


<!-- <div class="container-fluid"> -->


<div class="contents">
    <p id="record_count_text">Total active records <span id="record_count"><?= $searchModel->activeRecordsCounts ?></span></p>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table display', 'id' => 'DataTable'],
            //'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'columns' => [

                [
                    'attribute' => 'name',
                    'encodeLabel' => false,
                    'label' => 'Marques Name',
                    'sortLinkOptions' => ['class' => 'sortable'],
                    'value' => function ($data) {
                        return $data->name;
                    }

                ],
                [
                    'attribute' => 'brand_name',
                    'encodeLabel' => false,
                    'label' => 'Brand',
                    'sortLinkOptions' => ['class' => 'sortable'],
                    'value' => function ($data) {

                        return $data->brand->brand_name;
                    }

                ],
                [
                    'attribute' => 'status',
                    'label' => 'Status',
                    'format' => 'raw',
                    'sortLinkOptions' => ['class' => 'sortable'],
                    'value' => function ($data) {
                        return '<div class="custom-control custom-switch" data-key="' . $data->id . '" data-status="' . $data->status  . '">

                            <input class="custom-control-input" id="switch' . $data->id . '" name="switch" type="checkbox" ' . ($data->status == 1 ? 'checked' : '') . '>
                            
                            <label class="custom-control-label" for="switch' . $data->id . '">' . ($data->status == 1 ? 'Active' : 'Inactive') . '</label>
                            </div>';
                    }
                ],
                [
                    'attribute' => 'updated_at',
                    'encodeLabel' => false,
                    'sortLinkOptions' => ['class' => 'sortable'],
                    'format' => 'raw',
                    'label' => 'Last Edited (EST) <i class="fa fa-sort xs-pl-2" aria-hidden="false"></i>',
                    'value' => function ($data) {
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


                            $url = Url::toRoute(['marques/view', 'id' => $model->id, 'type' => 'view']);
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
<!-- </div> -->

<?php
$this->registerJs('
    $(document).on("click", ".custom-control-label", function(e) { 
        var status = $(this).parent("div").find(".custom-control-input").prop("checked") == true ? 1 : 0 ;

        var id = $(this).parents("div").attr("data-key");
        var _this = $(this);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "' . $web . '/marques/status-update",
            data: {"status": status, "id": id, "_csrf-frontend": "' . Yii::$app->request->getCsrfToken() . '"},
            success: function(response)
            {
                if(response.status == "error"){
                    _this.prop("checked", !_this.prop("checked"));
                    return false;
                }
                
                if(response.data==1){
                    var count = parseInt($("#record_count").html());
                    console.log("aafter ajax 0");
                    $("#record_count").html(count+1);
                 _this.parent("div").find(".custom-control-input").removeAttr("checked");
                 _this.find(".active_status").html("Inactive");
                 }else{
                    var count = parseInt($("#record_count").html());
                    console.log("aafter ajax 0");
                    $("#record_count").html(count-1);
                    _this.parent("div").find(".custom-control-input").attr("checked","checked");
                    _this.find(".active_status").html("Active");
                }
            }
            });
        });
        


        ', View::POS_READY);

?>