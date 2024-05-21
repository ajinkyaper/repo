<?php
/* @var $this yii\web\View */
$this->title = 'Report';
?>


<?php $this->beginBlock('headerblock') ?>
<div class="col-lg-8 col-sm-4"><a href="<?= Url::toRoute(['category/index']); ?>" class="title-link" ><h1><?= Html::encode($this->title) ?></h1></a></div>

<?php $this->endBlock() ?>
<!-- <h1>exportreport/index</h1> -->

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
