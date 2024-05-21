<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\bootstrap\ActiveForm;
$this->title = 'Report';
?>

<?php $this->beginBlock('headerblock') ?>
<div class="col-lg-8 col-sm-4"><a href="<?= Url::toRoute(['exportreport/index']); ?>" class="title-link" ><h1><?= Html::encode($this->title) ?></h1></a></div>

<?php $this->endBlock() ?>
<?php echo isset($version)?"<!--Version ".$version."-->":"<!--Version".'1.0'."-->"; ?>
<div class="contents">
  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      
      <?php $form = ActiveForm::begin(['id' => 'report-form']); ?>
      <!-- Filter -->
      <div class="row">
          <div class="col-lg-2 col-md-2 col-sm-2"> <p style="text-align:right;font-weight:600">From Date:</p> </div>
          <div class="col-lg-3 col-md-3 col-sm-3">
              <?= $form->field($model, 'from_date')->textInput(['class' => 'form-control', 'id' => 'frm_date', 'autocomplete'=>"off"])->label(false) ?>
          </div>
          <div class="col-1g-2 col-md-2 col-sm-2"><p style="text-align:right;font-weight:600">To Date: </p> </div>
          <div class="col-lg-3 col-md-3 col-sm-3">
              <?= $form->field($model, 'to_date')->textInput(['class' => 'form-control', 'id' => 't_date', 'autocomplete'=>"off"])->label(false) ?>
          </div>

          <div class="col-lg-2"> <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?> </div>
          <?php ActiveForm::end(); ?>
      </div>
      <!-- Filter /-->

      <div class="clearfix"></div>

      <!-- tabs Nav -->
      <!--        <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab"
                    data-toggle="tab">By Educator</a></li>
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">By Occasion</a></li>
                <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">By Marque</a></li>
                <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">By Cocktail</a></li>
              </ul> tabs Nav /
      
              <div class="tab-content">
      
                 Tab 01 
                <div role="tabpanel" class="tab-pane active" id="home">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Header</th>
                          <th>Header</th>
                          <th>Header</th>
                          <th>Header</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1,001</td>
                          <td>Lorem</td>
                          <td>ipsum</td>
                          <td>dolor</td>
                          <td>sit</td>
                        </tr>
                        <tr>
                          <td>1,002</td>
                          <td>amet</td>
                          <td>consectetur</td>
                          <td>adipiscing</td>
                          <td>elit</td>
                        </tr>
                        <tr>
                          <td>1,003</td>
                          <td>Integer</td>
                          <td>nec</td>
                          <td>odio</td>
                          <td>Praesent</td>
                        </tr>
      
                        <tr>
                          <td>1,005</td>
                          <td>Nulla</td>
                          <td>quis</td>
                          <td>sem</td>
                          <td>at</td>
                        </tr>
      
                        <tr>
                          <td>1,003</td>
                          <td>libero</td>
                          <td>Sed</td>
                          <td>cursus</td>
                          <td>ante</td>
                        </tr>
                        <tr>
                          <td>1,004</td>
                          <td>dapibus</td>
                          <td>diam</td>
                          <td>Sed</td>
                          <td>nisi</td>
                        </tr>
      
                      </tbody>
                    </table>
                  </div>
                </div> Tab 01 /
      
                 Tab 02 
                <div role="tabpanel" class="tab-pane" id="profile">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Header</th>
                          <th>Header</th>
                          <th>Header</th>
                          <th>Header</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1,001</td>
                          <td>Lorem</td>
                          <td>ipsum</td>
                          <td>dolor</td>
                          <td>sit</td>
                        </tr>
                        <tr>
                          <td>1,002</td>
                          <td>amet</td>
                          <td>consectetur</td>
                          <td>adipiscing</td>
                          <td>elit</td>
                        </tr>
                        <tr>
                          <td>1,003</td>
                          <td>Integer</td>
                          <td>nec</td>
                          <td>odio</td>
                          <td>Praesent</td>
                        </tr>
                        <tr>
                          <td>1,003</td>
                          <td>libero</td>
                          <td>Sed</td>
                          <td>cursus</td>
                          <td>ante</td>
                        </tr>
                        <tr>
                          <td>1,004</td>
                          <td>dapibus</td>
                          <td>diam</td>
                          <td>Sed</td>
                          <td>nisi</td>
                        </tr>
                        <tr>
                          <td>1,005</td>
                          <td>Nulla</td>
                          <td>quis</td>
                          <td>sem</td>
                          <td>at</td>
                        </tr>
      
                      </tbody>
                    </table>
                  </div>
                </div> Tab 02 /
      
                 Tab 03 
                <div role="tabpanel" class="tab-pane" id="messages">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Header</th>
                          <th>Header</th>
                          <th>Header</th>
                          <th>Header</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1,001</td>
                          <td>Lorem</td>
                          <td>ipsum</td>
                          <td>dolor</td>
                          <td>sit</td>
                        </tr>
                        <tr>
                          <td>1,002</td>
                          <td>amet</td>
                          <td>consectetur</td>
                          <td>adipiscing</td>
                          <td>elit</td>
                        </tr>
      
                        <tr>
                          <td>1,005</td>
                          <td>Nulla</td>
                          <td>quis</td>
                          <td>sem</td>
                          <td>at</td>
                        </tr>
      
                        <tr>
                          <td>1,003</td>
                          <td>Integer</td>
                          <td>nec</td>
                          <td>odio</td>
                          <td>Praesent</td>
                        </tr>
                        <tr>
                          <td>1,003</td>
                          <td>libero</td>
                          <td>Sed</td>
                          <td>cursus</td>
                          <td>ante</td>
                        </tr>
                        <tr>
                          <td>1,004</td>
                          <td>dapibus</td>
                          <td>diam</td>
                          <td>Sed</td>
                          <td>nisi</td>
                        </tr>
      
                      </tbody>
                    </table>
                  </div>
                </div> Tab 03 /
      
                 Tab 04 
                <div role="tabpanel" class="tab-pane" id="settings">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Header</th>
                          <th>Header</th>
                          <th>Header</th>
                          <th>Header</th>
                        </tr>
                      </thead>
                      <tbody>
      
                        <tr>
                          <td>1,002</td>
                          <td>amet</td>
                          <td>consectetur</td>
                          <td>adipiscing</td>
                          <td>elit</td>
                        </tr>
                        <tr>
                          <td>1,003</td>
                          <td>Integer</td>
                          <td>nec</td>
                          <td>odio</td>
                          <td>Praesent</td>
                        </tr>
                        <tr>
                          <td>1,003</td>
                          <td>libero</td>
                          <td>Sed</td>
                          <td>cursus</td>
                          <td>ante</td>
                        </tr>
                        <tr>
                          <td>1,001</td>
                          <td>Lorem</td>
                          <td>ipsum</td>
                          <td>dolor</td>
                          <td>sit</td>
                        </tr>
                        <tr>
                          <td>1,005</td>
                          <td>Nulla</td>
                          <td>quis</td>
                          <td>sem</td>
                          <td>at</td>
                        </tr>
                        <tr>
                          <td>1,004</td>
                          <td>dapibus</td>
                          <td>diam</td>
                          <td>Sed</td>
                          <td>nisi</td>
                        </tr>
                        <tr>
                          <td>1,005</td>
                          <td>Nulla</td>
                          <td>quis</td>
                          <td>sem</td>
                          <td>at</td>
                        </tr>
      
      
                      </tbody>
                    </table>
                  </div>
                </div> Tab 04 /
                <button type="submit" class="btn btn-primary pull-right">Export</button>
              </div>-->
  </div>
</div>