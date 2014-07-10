<?php
/* @var $this AbsenController */
/* @var $tanggal string */
/* @var $absenMasuk CActiveDataProvider */
/* @var $absenPulang CActiveDataProvider */

Yii::import('ext.Utilities');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.datetimepicker.js');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/jquery.datetimepicker.css');
?>

<h1>Absen</h1>
<hr>
	
<br>
<form action="" method="post">
	<div class="row">
		<div class="col-md-3">
			<h4>Tanggal</h4>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control dateTimePicker" name="Tanggal">
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<button class="btn btn-warning"> Pilih</button>
		</div>
	</div>
</form>

<br>


<?php if(isset($absenMasuk)): ?>
	<hr>
	<h2><?php echo $tanggal?></h2>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3>Absen Masuk</h3>
		</div>
		<?php $gridView = $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$absenMasuk,
			'template'=>"{items}",
			'columns' => array (
				array(
					'name'=>'nama',
					'value'=>'$data->user->fullname',
				),
				array(
					'name'=>'Waktu',
					'value'=>'Utilities::timestampToFormattedDate($data->timestamp, "G:i")'
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
	
	<hr>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3>Absen Pulang</h3>
		</div>
		<?php $gridView = $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$absenPulang,
			'template'=>"{items}",
			'columns' => array (
				array(
					'name'=>'nama',
					'value'=>'$data->user->fullname',
				),
				array(
					'name'=>'Waktu',
					'value'=>'Utilities::timestampToFormattedDate($data->timestamp, "G:i")'
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
	  format:'d-m-Y',
	  mask:true,
	  lang:'en'
	});
</script>