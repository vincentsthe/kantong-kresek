<?php
/* @var $this InvoicePembelianController */
/* @var $dataProvider CActiveDataProvider */

Yii::import('ext.Utilities');
?>

<h1>Invoice Pembelian</h1>
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
		<h4 class="pull-left">Daftar Invoice Pembelian</h4>
		<form name="form1" class="form form-inline pull-right p-r-10" action="?" method="GET">
			<div class="input-group" style="width: 300px">
				<input type="text" class="form-control" name="filter" value="<?php if(isset($_GET['filter'])) echo $_GET['filter']; ?>">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" onclick="document.form1.submit()"><span class="glyphicon glyphicon-search"></span></button>
				</span>
			</div>
		</form>
		<div class="clearfix"></div>
	</div>
	<?php $gridView = $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'template'=>"{items}",
		'columns' => array (
			'id',
			'nomor',
			'nama_supplier',
			array(
				'name'=> 'Waktu Penerbitan',
				'value'=> 'Utilities::timestampToFormattedDate($data->waktu_penerbitan)',
			),
			array(
				'name'=> 'Jatuh Tempo Pembayaran',
				'value' => 'Utilities::timestampToFormattedDate($data->jatuh_tempo_pembayaran)',
			),
			array(
				'name'=>'',
				'type'=>'raw',
				'value'=>function($data) {
					return 	CHtml::link('<span class="glyphicon glyphicon-search"></span>', array('invoicePembelian/view', 'id'=>$data->id));
				},
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

<?php $gridView->renderPager(); ?>