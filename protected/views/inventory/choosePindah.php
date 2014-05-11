<?php
/* @var $this InventoryController */
/* @var $barang Inventory */
/* @var $model PindahInventoryForm*/

Yii::import('ext.Utilities');
?>

<h1>Pindah Barang</h1>
<h5><?php echo $barang->nama_barang . " dari " . $barang->lokasi0->nama?></h5>
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

<div class="row">
	<div class="col-md-3">
		<h5 class="font-light">Nama Barang</h5>
	</div>
	<div class="col-md-9">
		<h5><?php echo $barang->nama_barang;?></h5>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<h5 class="font-light">Nomor Invoice</h5>
	</div>
	<div class="col-md-9">
		<h5><?php echo $barang->invoice->nomor;?></h5>
	</div>
</div>

<hr>

<div class="row">

	<div class="col-md-6">
		<h5><b>Jumlah Asal</b></h5>
		<h5 style="padding-left:10%;margin-bottom:20px;"><?php echo $barang->jumlah_barang;?></h5>
		<h5><b>Lokasi Asal</b></h5>
		<h5 style="padding-left:10%;margin-bottom:20px;"><?php echo $barang->lokasi0->nama;?></h5>
	</div>

	<div class="form col-md-5">
	
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'pindah-form',
			// Please note: When you enable ajax validation, make sure the corresponding
			// controller action is handling ajax validation correctly.
			// There is a call to performAjaxValidation() commented in generated controller code.
			// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation'=>true,
		)); ?>
		
			<?php echo $form->errorSummary($model); ?>
		
			<div class="row">
				<?php echo $form->labelEx($model,'jumlah'); ?>
				<?php echo $form->textField($model,'jumlah', array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'jumlah'); ?>
			</div>
		
			<div class="row">
				<?php echo $form->labelEx($model,'lokasiTujuan'); ?>
				<?php echo $form->dropDownList($model,'lokasiTujuan', Cabang::findAllLocation(), array('id'=>'lokasi' ,'class'=>'form-control', 'empty'=>'Pilih Cabang')); ?>
				<?php echo $form->error($model,'lokasiTujuan'); ?>
			</div>
		
		<?php $this->endWidget(); ?>
	
	</div>
</div>
<hr>
<div class="row extra-padding">
	<div class="col-md-3">
		<h5>Harga Minimum</h5>
	</div>
	<div class="col-md-3">
		<h5><b><?php echo Utilities::currency($barang->harga_minimum);?></b></h5>
	</div>
	<div class="col-md-3">
		<h5>Harga Minimum</h5>
	</div>
	<div class="col-md-3">
		<h5><b id="harga_minimum">-</b></h5>
	</div>
</div>
<div class="row extra-padding">
	<div class="col-md-3">
		<h5>Harga Minimum Khusus</h5>
	</div>
	<div class="col-md-3">
		<h5><b><?php echo Utilities::currency($barang->harga_minimum_khusus);?></b></h5>
	</div>
	<div class="col-md-3">
		<h5>Harga Minimum Khusus</h5>
	</div>
	<div class="col-md-3">
		<h5><b id="harga_minimum_khusus">-</b></h5>
	</div>
</div>
<p class="font-light">*Bila di kedua tempat terdapat barang yang sama, harga di tempat tujuan yang dipakai.</p>

<hr>
<br><br>
<div class="text-center">
	<button class="btn btn-primary" onclick="document.getElementById('pindah-form').submit()">Pindahkan</button>
</div>
<br><br>

<script type="text/javascript">
	var invoiceId1 = <?php echo $barang->invoice_id; ?>;
	var namaBarang1 = "<?php echo $barang->nama_barang; ?>";
	$("#lokasi").change(function() {
		var tujuan1 = $("#lokasi").val();
		var data = {
			invoiceId: invoiceId1,
			namaBarang: namaBarang1,
			tujuan: tujuan1
		}
		$.post("<?php echo Yii::app()->createUrl('inventory/minimum');?>", data, function(result) {
			$("#harga_minimum").html(result);
		}, "html");
		$.post("<?php echo Yii::app()->createUrl('inventory/minimumKhusus');?>", data, function(result) {
			$("#harga_minimum_khusus").html(result);
		}, "html");
	});
</script>







