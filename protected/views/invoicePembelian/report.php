<?php
/* @var $this InvoicePembelianController */
/* @var $reportForm ReportForm*/
/* @var $invoices CActiveDataProvider */
/* @var $transaction integer */
/* @var $totalTransaction integer */

Yii::import('ext.Utilities');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.datetimepicker.js');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/jquery.datetimepicker.css');
?>

<h1>Laporan Pembelian</h1>
<hr>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'report-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row">
		<div class="col-md-12">
			<h5><?php echo $form->labelEx($reportForm,'supplier'); ?></h5>
			<?php echo $form->textField($reportForm,'supplier',array('class'=>'form-control')); ?>
			<?php echo $form->error($reportForm,'supplier'); ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<h4>Dari</h4>
		</div>
		<div class="col-md-6">
			<h4>Sampai</h4>
		</div>
	</div>
	
	<br>
	<div class="row">
		<div class="col-md-6">
			<?php echo $form->textField($reportForm, 'startTime', array('class'=>'form-control dateTimePicker')); ?>
		</div>
		<div class="col-md-6">
			<?php echo $form->textField($reportForm, 'endTime', array('class'=>'form-control dateTimePicker')); ?>
		</div>
	</div>
	
	<br>
	<div class="row">
		<div class="col-md-12">
			<?php echo CHtml::submitButton('Cari', array('class' => 'btn btn-warning')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

<?php if(isset($invoices)): ?>
	<hr>
	<div class="row">
		<div class="col-md-3">
			<h4>Jumlah Pembelian</h4>
		</div>
		<div class="col-md-9">
			<h4>: <?php echo $transaction; ?></h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<h4>Total Transaksi</h4>
		</div>
		<div class="col-md-9">
			<h4>: <?php echo Utilities::currency($totalTransaction); ?></h4>
		</div>
	</div>
	
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3>Daftar Traksaksi</h3>
		</div>
		<?php $gridView = $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$invoices,
			'template'=>"{items}",
			'columns' => array (
				'id',
				array(
					'name'=>'Nomor Invoice',
					'value'=>'$data->nomor',
				),
				'nama_supplier',
				'jatuh_tempo_pembayaran',
				array(
					'name'=>'Waktu Pembelian',
					'value'=>'Utilities::timestampToFormattedDate($data->waktu_penerbitan)'
				),
				array(
					'name'=>'Total Transaksi',
					'value'=>'Utilities::currency($data->getTotalPrice())'
				),
				array(
					'name'=>'',
					'type'=>'raw',
					'value'=>function($data) {
						return CHtml::link('<span class="glyphicon glyphicon-search"></span>', array('invoicePembelian/view', 'id'=>$data->id));
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
<?php endif;?>

<script type="text/javascript">
	$('.dateTimePicker').datetimepicker({
	  format:'d-m-Y H:i',
	  mask:true,
	  lang:'en'
	});
</script>