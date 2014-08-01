<?php
/* @var $this InvoicePembelianController */
/* @var $invoice InvoicePembelian */
/* @var $listItem Pembelian[] */

Yii::import('ext.Utilities');
$hargaTotal = 0;
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


<div class="row">
	<div class="col-md-3">
		<h5 class="font-light">Supplier</h5>
	</div>
	<div class="col-md-9">
		<h5><?php echo $invoice->nama_supplier?></h5>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<h5 class="font-light">Biaya Pengiriman</h5>
	</div>
	<div class="col-md-9">
		<h5><?php 
			echo Utilities::currency($invoice->biaya_pengiriman);
		?></h5>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<h5 class="font-light">Jatuh Tempo Pembayaran</h5>
	</div>
	<div class="col-md-9">
		<h5><?php echo Utilities::timestampToFormattedDate($invoice->jatuh_tempo_pembayaran); ?></h5>
	</div>
</div>

<div class="row">
	<div class="col-md-12 font-light">
		<h4>Comment Internal</h4>
	</div>
	<div class="col-md-12">
		<?php 
			if(strlen($invoice->comment_internal) != 0) {
				echo $invoice->comment_internal;
			} else {
				echo "&nbsp&nbsp&nbsp-";
			}
		?>
	</div>
</div>

<div class="row">
	<div class="col-md-12 font-light">
		<h4>Comment External</h4>
	</div>
	<div class="col-md-12">
		<?php 
			if(strlen($invoice->comment_external) != 0) {
				echo $invoice->comment_external;
			} else {
				echo "&nbsp&nbsp&nbsp-";
			}
		?>
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
	<?php $i=0; ?>
	<?php foreach($listItem as $item): ?>
		<tr>
			<td><?php echo $item->nama_barang?></td>
			<td><?php echo $item->quantity?></td>
			<td class="text-right"><?php echo Utilities::currency($item->harga); ?></td>
			<td class="text-right"><?php echo Utilities::currency($item->harga * $item->quantity); ?></td>
			<td class="text-center"><?php echo CHtml::link('<span class="glyphicon glyphicon-remove"></span>', array('invoicePembelian/removeItem', 'index'=>$i)); ?></td>
		</tr>
		<?php $hargaTotal += $item->harga * $item->quantity?>
		<?php $i++; ?>
	<?php endforeach;?>
</table>

<?php echo CHtml::link('Tambah Barang', array('invoicePembelian/addItem'), array('class'=>'btn btn-primary pull-right')); ?>
<br><br><br><br>

<div class="row">
	<div class="col-md-7"></div>
	<div class="col-md-3">
		<h5>Total Harga</h5>
		<h5>Biaya Pengiriman</h5>
		<h5><b>Total</b></h5>
	</div>
	<div class="col-md-2">
		<h5><?php echo Utilities::currency($hargaTotal); ?></h5>
		<h5><?php echo Utilities::currency($invoice->biaya_pengiriman); ?></h5>
		<h5><b><?php echo Utilities::currency($hargaTotal + $invoice->biaya_pengiriman); ?></b></h5><br>
	</div>
</div>

<div class="text-center">
	<?php echo CHtml::link('Terbitkan Invoice', array('invoicePembelian/doCreate'), array('class'=>'btn btn-warning align-center')); ?>
</div>
<br><br><br>


