<?php
/* @var $this InventoryController */
/* @var $model Inventory */

Yii::import('ext.utilities');
?>

<h1><?php echo $model->nama_barang; ?></h1>
<hr>

<div class="row">
	<div class="col-md-3">
		<h5 class="font-light">Jumlah</h5>
	</div>
	<div class="col-md-9">
		<h5><?php echo $model->jumlah_barang; ?></h5>
	</div>
</div>


<div class="row">
	<div class="col-md-3">
		<h5 class="font-light">Lokasi</h5>
	</div>
	<div class="col-md-9">
		<?php if($model->lokasi0 != null): ?>
			<h5><?php echo $model->lokasi0->nama; ?></h5>
		<?php else: ?>
			<h5>Belum ditempatkan</h5>
		<?php endif;?>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<h5 class="font-light">Invoice</h5>
	</div>
	<div class="col-md-9">
		<h5><?php echo CHtml::link($model->invoice->nomor, array('invoicePembelian/view', 'id'=>$model->invoice->id)); ?></h5>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<h5 class="font-light">Harga</h5>
	</div>
	<div class="col-md-9">
		<?php if($model->harga != null): ?>
			<h5><?php echo Utilities::currency($model->harga); ?></h5>
		<?php else: ?>
			<h5>-</h5>
		<?php endif;?>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<h5 class="font-light">Harga Minimum</h5>
	</div>
	<div class="col-md-9">
		<?php if($model->harga_minimum != null): ?>
			<h5><?php echo Utilities::currency($model->harga_minimum); ?></h5>
		<?php else: ?>
			<h5>-</h5>
		<?php endif;?>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<h5 class="font-light">Harga Minimum Khusus</h5>
	</div>
	<div class="col-md-9">
		<?php if($model->harga_minimum_khusus != null): ?>
			<h5><?php echo Utilities::currency($model->harga_minimum_khusus); ?></h5>
		<?php else: ?>
			<h5>-</h5>
		<?php endif;?>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<h5 class="font-light">Serial Number</h5>
	</div>
	<div class="col-md-9">
		<h5><?php echo $model->serial_number; ?></h5>
	</div>
</div>

