<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kop\y2sp\ScrollPager;
use yii\web\View;
use app\components\Cms;
use app\models\Educators;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'iPad User';
$this->params['breadcrumbs'][] = $this->title;
$web = Yii::getAlias('@web');
$isSearch = Cms::formShowHide("EducatorsSearch");
$totalRecords = Educators::find()->where(['status' => 1])->count();
//$isSearch = Cms::formShowHide("searchblock");
?>
<style>
    .selectBox {
        position: relative;
    }

    .overSelect {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }

    #checkboxes {
        display: none;
        border: 1px #d5d5d5 solid;
        padding: 10px;
    }

    #checkboxes label {
        display: block;
    }

    #checkboxes label input {
        margin-right: 10px;
    }
</style>

<style type="text/css" media="screen">
    .table th a,
    .table th {
        color: #fff;
        font-size: 16px;
        font-weight: normal;

    }
</style>
<?php $this->beginBlock('headerblock') ?>
<div class="col-lg-8 col-sm-8"><a href="<?= Url::toRoute(['ipadusers/index']); ?>" class="title-link">
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
        <li class="breadcrumb-item"><a href="<?= Url::to(['/ipadusers']) ?>">List</a></li>
    </ol>
</nav>
<div class="search-box" style="display: <?= $isSearch ?>" id="search-box">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
</div>
<?php /*?><div class="search-box" style="display: <?= $isSearch ?>" id="search-box">
	<?php echo $this->render('_search', ['model' => $searchModel]); ?>
</div><?php */ ?>
<?php $this->endBlock() ?>

<div class="container-fluid">
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
                        'attribute' => 'edu_name',
                        'encodeLabel' => false,
                        'label' => 'Name',
                        'sortLinkOptions' => ['class' => 'sortable'],
                        'value' => function ($data) {
                            return $data->edu_name;
                        }


                    ],

                    [
                        'attribute' => 'name',
                        'encodeLabel' => false,
                        'label' => 'Market <i class="fa fa-sort xs-pl-2" aria-hidden="true"></i>',
                        'sortLinkOptions' => ['class' => 'sortable'],
                        'value' => function ($data) {
                            return $data->market->name;
                        }

                    ],

                    [
                        'attribute' => 'status',
                        'label' => 'Status',
                        'format' => 'raw',
                        'sortLinkOptions' => ['class' => 'sortable'],
                        'value' => function ($data) {
                            return '<div class="custom-control custom-switch" data-key="' . $data->edu_id . '" data-status="' . $data->status . '">

                        <input class="custom-control-input" id="switch" name="switch" type="checkbox" ' . ($data->status == 1 ? 'checked' : '') . '>
                        <label class="custom-control-label" style="cursor:pointer">' . ($data->status == 1 ? 'Active' : 'Inactive') . '</label></div>';
                        }

                    ],
                    [
                        'attribute' => 'email',
                        'encodeLabel' => false,
                        'sortLinkOptions' => ['class' => 'sortable'],
                        'label' => 'Email Address <i class="fa fa-sort xs-pl-2" aria-hidden="true"></i>',
                        'value' => function ($data) {
                            return $data->email;
                        }

                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'View',
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model) {


                                $url = Url::toRoute(['view', 'id' => $model->edu_id]);
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
    <!-- <div class="dvloader" id="dvloader">Load more</div> -->
</div>


<?php
$this->registerJs('
    $(document).on("click", ".custom-control-label", function(e) { 
        
        var status = $(this).parent("div").find(".custom-control-label").text() == "Inactive" ? 0 : 1;
        var id = $(this).parents("div").attr("data-key");
        var _this = $(this);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "' . $web . '/ipadusers/status-update",
            data: {"status": status, "id": id, "_csrf-frontend": "' . Yii::$app->request->getCsrfToken() . '"},
            success: function(response)
            {
                if(response.status == "error"){
                    _this.prop("checked", !_this.prop("checked"));
                    return false;
                }
                
                if(response.data==1){
                var count = parseInt($("#record_count").html());
                $("#record_count").html(count+1);
                 
                 _this.parent("div").find(".custom-control-input").attr("checked","checked");
                 _this.text("Active");
                }else{
                    _this.parent("div").find(".custom-control-input").removeAttr("checked");

                    _this.text("Inactive");
                    var count = parseInt($("#record_count").html());
                    $("#record_count").html(count-1);
                }
            }
            });
        });
        

        ', View::POS_READY);

?>

<!-- <script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function(){
	$(function() {
        $("#dvloader").show();
        //$(".contents").load("data.php", function(){ $("#dvloader").hide(); });
        return false;
	});
});

var expanded = false;

function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}
</script> -->