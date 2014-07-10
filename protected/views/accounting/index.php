<?php
/* @var $this AccountingController */
/* @var $dataProvider CActiveDataProvider */

Yii::import('ext.Utilities');
?>

<h1>Data Administrasi</h1>
<hr>
<?php if(Yii::app()->user->hasFlash('error')): ?>
	<div class="alert alert-danger">
		<?php echo Yii::app()->user->getFlash('error'); ?>
	</div>
<?php endif;?>

<?php if(Yii::app()->user->hasFlash('success')): ?>
	<div class="alert alert-success">
		<?php echo Yii::app()->user->getFlash('success'); ?>
	</div>
<?php endif;?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Data Administrasi</h4>
		<div class="clearfix"></div>
	</div>
	<?php $gridView = $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'template'=>"{items}",
		'columns' => array (
			'id',
			'kode',
			'pesan',
			array(
				'name'=>'Jumlah Transaksi',
				'value'=>'Utilities::currency($data->transaksi)'
			),
		),
		'itemsCssClass' => 'table table-striped',
		'pager' => array (
			'header'=>'',
			'internalPageCssClass'=>'sds',
			'htmlOptions' => array (
				'class'=>'pagination',
			)
		)
	)); ?>
</div>
