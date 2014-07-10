<?php
/* @var $this InvoicePenjualanController */
/* @var $invoice InvoicePenjualan */

Yii::import('ext.Utilities');
$listPenjualan = $invoice->penjualans;

$hargaTotal = 0;
$diskonTotal = 0;
?>

<h1>Invoice Penjualan #<?php echo $invoice->nomor; ?></h1>
<hr>

<?php if($invoice->batal == 1): ?>
	<h2 style="color:red">DIBATALKAN</h2>
<?php endif; ?>

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
	<div class="col-xs-6">
		<h4><b>Pembeli:</b></h4>
		<h5><?php echo $invoice->nama_pembeli; ?></h5>
		<h5><?php echo $invoice->alamat_pembeli; ?></h5>
		<h5><?php echo $invoice->telpon_pembeli; ?></h5>
	</div>
	<div class="col-xs-6">
		<h4><b>Dikirim:</b></h4>
		<h5><?php echo $invoice->nama_terkirim; ?></h5>
		<h5><?php echo $invoice->alamat_terkirim; ?></h5>
		<h5><?php echo $invoice->telpon_terkirim; ?></h5>
	</div>
</div>

<h2>Daftar Barang</h2>

<table class="table table-striped table-bordered">
	<tr>
		<th>Nama Barang</th>
		<th>Quantity</th>
		<th>Harga</th>
		<th>Total</th>
	</tr>
	<?php foreach($listPenjualan as $item): ?>
		<tr>
			<td><?php echo $item->nama_barang?></td>
			<td><?php echo $item->quantity?></td>
			<td class="text-right"><?php echo Utilities::currency($item->harga); ?></td>
			<td class="text-right"><?php echo Utilities::currency($item->harga * $item->quantity); ?></td>
		</tr>
		<?php $hargaTotal += $item->harga * $item->quantity?>
		<?php $diskonTotal += ($item->harga - $item->harga_terjual) * $item->quantity?>
	<?php endforeach;?>
</table>

<div class="row">
	<div class="col-md-7">
		<h4>Komentar</h4>
		<?php echo $invoice->comment_external; ?>
	</div>
	<div class="col-md-3">
		<h5>Harga Total</h5>
		<h5>Biaya Pengiriman</h5>
		<h5>Jumlah</h5>
		<h5>Diskon</h5>
		<h5><b>Total</b></h5><br>
		<h5>Pembayaran</h5>
		<h5><b>Down Payment</b></h5>
	</div>
	<div class="col-md-2">
		<h5><?php echo Utilities::currency($hargaTotal); ?></h5>
		<h5><?php echo Utilities::currency($invoice->biaya_pengiriman); ?></h5>
		<h5><?php echo Utilities::currency($hargaTotal); ?></h5>
		<h5><?php echo Utilities::currency($diskonTotal); ?></h5>
		<h5><b><?php echo Utilities::currency($hargaTotal - $diskonTotal); ?></b></h5><br>
		<h5><?php echo $invoice->jenis_pembayaran?></h5>
		<h5><b><?php echo Utilities::currency($invoice->down_payment); ?></b></h5>
	</div>
</div>
<br><br><br>
<div class="text-center">
	<?php echo CHtml::link('Print', array('invoicePenjualan/print', 'id'=>$invoice->id), array('class'=>'btn btn-warning', 'target'=>'_blank')); ?>
</div>
<br><br>
<?php echo CHtml::link('Batalkan', array('invoicePenjualan/cancel', 'id'=>$invoice->id), array('class'=>'btn btn-danger', 'onclick'=>'return confirm("Batalkan transaksi ini.");')); ?>
<br><br><br>