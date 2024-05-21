<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kop\y2sp\ScrollPager;
use yii\web\View;
use app\models\Market;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CocktailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Markets';
$this->params['breadcrumbs'][] = $this->title;
$web = Yii::getAlias('@web');

?>
<?php $this->beginBlock('headerblock') ?>
<div class="col-lg-8 col-sm-8"><a href="<?= Url::toRoute(['market/index']); ?>" class="title-link">
    <h1><?= Html::encode($this->title) ?></h1>
  </a>
  <ul class="nav">
    <li><a href="#" class="btn search">Search</a></li>
    <li><a href="#" class="btn add add-icon" data-toggle="modal" data-target="#addnew">Add New</a></li>
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
  <p id="record_count_text">Total active records <span id="record_count"> <?= $searchModel->activeRecordsCounts  ?></span></p>
  <div class="table-responsive">
    <?= 
    GridView::widget([
      'dataProvider' => $dataProvider,
      'tableOptions' => ['class' => 'table display', 'id' => 'DataTable'],
      //'filterModel' => $searchModel,
      'layout' => "{items}\n{pager}",
      'columns' => [

        [
          'attribute' => 'name',
          'encodeLabel' => false,
          'label' => 'Category Name <i class="fa fa-sort xs-pl-2" aria-hidden="true"></i>',
          'value' => function ($data) {
            return $data->name;
          }

        ],
        [
          'attribute' => 'status',
          'label' => 'Status',
          'format' => 'raw',
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
          'label' => 'Last Edited (EST) <i class="fa fa-sort xs-pl-2" aria-hidden="false"></i>',
          'format' => 'raw',
          'value' => function ($data) {

            $update_time = ($data->updated_at != null) ? $data->updated_at : $data->created_at;
            $date = new DateTime($update_time);
            $date->setTimezone(Yii::$app->params['list_timezone']);
            $username = '<br/>' . $data->user->username;
            return $date->format(Yii::$app->params['date_time_format']) . $username;
          }

        ],
        [
          'class' => 'yii\grid\ActionColumn',
          'header' => 'Edit',
          'template' => '{view}',
          'buttons' => [
            'view' => function ($url, $model) {


              $url = Url::toRoute(['market/update', 'id' => $model->id, 'type' => 'view']);
              $url = "#";
              return Html::a('<i class="icon icon-edit" data-toggle="modal" data-id="' . $model->id . '" data-target="#cedit"></i"></i>', $url, [
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
        'triggerOffset' => $dataProvider->totalCount   / $dataProvider->pagination->pageSize,
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
<!-- </div> -->
<div class="text-center">
    <div class="dvloader" id="dvloader">Load more</div>
</div>
<?php
$this->registerJs('
    $(document).on("click", "[name=\'switch\']", function(e) { 
        var status = $(this).parent("div").find(".custom-control-label").text() == "Inactive" ? 0 : 1;
        //var status = $(this).prop("checked") == true ? 1 : 0 ;
        var id = $(this).parents("div").attr("data-key");
        //console.log("label_value", labeltext);

        console.log("id",id);   
        var _this = $(this);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "' . $web . '/market/status-update",
            data: {"status": status, "id": id, "_csrf-frontend": "' . Yii::$app->request->getCsrfToken() . '"},
            success: function(response)
            {
                if(response.status == "error"){
                    _this.prop("checked", !_this.prop("checked"));
                    return false;
                }
                
                if(response.data==1){
                 _this.parent("div").find(".custom-control-input").removeAttr("checked");
                 _this.find(".active_status").html("Inactive");
                var count = parseInt($("#record_count").html());
                $("#record_count").html(count+1);
                 }else{
                    var count = parseInt($("#record_count").html());
                    $("#record_count").html(count-1);
                    _this.parent("div").find(".custom-control-input").attr("checked","checked");
                    _this.find(".active_status").html("Active");
                }
            }
            });
        });

        $(document).on("click","#switchpopLabel",function(){
        
          console.log("here");
          $(this).text($(this).text() == "Inactive" ? "Active" : "Inactive");
          var status = $(this).text() == "Inactive" ? 0 : 1;
          $("#switchInput").val(status);
          if(status==0){
            $("#switchpop").prop("checked", true);           
          }else{
            $("#switchpop").prop("checked", false);
          }
        });

        ', View::POS_READY);

?>

<!-----edit popup------>
<div class="modal fade" id="cedit" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="categoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit</h5>
        <button type="button" class="close" data-bs-dismiss="modal"  aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
    </div>
  </div>
</div>
<!-----end edit popup------>

<!-----Add popup------>
<div class="modal fade add-new-popup" id="addnew" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="categoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body modal-body-add">

      </div>
    </div>
  </div>
</div>
<!-----end Add popup------>



<?php
$this->registerJs('
     $(".icon-edit").click(function(){
       
       var marketid = $(this).data("id");

       // AJAX request
       $.ajax({
        url: "' . $web . '/market/update/",
        type: "get",
        data: {id: marketid},
        async:false,
        success: function(response){ 
          // Add response in Modal body
          $(".modal-body").html(response);

          // Display Modal
          $("#cedit").modal("show"); 
        }
      });
    });

         $(".add-icon").click(function(){
       


       // AJAX request
       $.ajax({
        url: "' . $web . '/market/create/",
        type: "get",
        async:false,
        success: function(response){ 
          // Add response in Modal body
          $(".modal-body-add").html(response);

          // Display Modal
          $("#addnew").modal("show"); 
        }
      });
    });

  ', View::POS_READY);
?>