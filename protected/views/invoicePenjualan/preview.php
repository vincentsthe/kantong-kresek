<?php
/* @var $this InvoicePembelianController */
/* @var $contact PenjualanContactForm */
/* @var $listPenjualan PenjualanBaru[] */

Yii::import('ext.Utilities');
$hargaTotal = 0;
?>

<h1>Invoice Penjualan</h1>
<hr>

<div class="row">
	<div class="col-md-6">
		<h4><b>Pembeli:</b></h4>
		<h5><?php echo $contact->nama_pembeli; ?></h5>
		<h5><?php echo $contact->alamat_pembeli; ?></h5>
		<h5><?php echo $contact->telpon_pembeli; ?></h5>
	</div>
	<div class="col-md-6">
		<h4><b>Dikirim:</b></h4>
		<h5><?php echo $contact->nama_terkirim; ?></h5>
		<h5><?php echo $contact->alamat_terkirim; ?></h5>
		<h5><?php echo $contact->telpon_terkirim; ?></h5>
	</div>
</div>

<h2>Daftar Barang</h2>

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

<table class="table table-striped table-bordered">
	<tr>
		<th>Nama Barang</th>
		<th>Quantity</th>
		<th>Harga</th>
		<th>Total</th>
		<th></th>
	</tr>
	<?php foreach($listPenjualan as $item): ?>
		<tr>
			<td><?php echo $item->nama_barang?></td>
			<td><?php echo $item->quantity?></td>
			<td class="text-right"><?php echo Utilities::currency($item->harga); ?></td>
			<td class="text-right"><?php echo Utilities::currency($item->harga * $item->quantity); ?></td>
			<td class="text-center"><?php echo CHtml::link('<span class="glyphicon glyphicon-remove"></span>', array('invoicePenjualan/removeItem', 'inventory_id'=>$item->inventory_id));?></td>
		</tr>
		<?php $hargaTotal += $item->harga * $item->quantity?>
	<?php endforeach;?>
</table>

<?php echo CHtml::link('Tambah Barang', array('invoicePenjualan/chooseItem'), array('class'=>'btn btn-primary pull-right')); ?>
<br><br><br><br>

<div class="row">
	<div class="col-md-7"></div>
	<div class="col-md-3">
		<h5><b>Total</b></h5>
	</div>
	<div class="col-md-2">
		<h5><?php echo Utilities::currency($hargaTotal); ?></h5>
	</div>
</div>


<?php echo CHtml::link('<span class="glyphicon glyphicon-chevron-left"></span>Informasi', array('invoicePenjualan/create'), array('class'=>'btn btn-warning pull-left')); ?>
<?php echo CHtml::link('Selanjutnya<span class="glyphicon glyphicon-chevron-right"></span>', array('invoicePenjualan/pembayaran'), array('class'=>'btn btn-warning pull-right')); ?>

<br><br><br>


