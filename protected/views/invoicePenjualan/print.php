<?php
	/* @var $this InvoicePenjualanController */
	/* @var $invoice InvoicePenjualan */

	Yii::import('ext.Utilities');
	$listPenjualan = $invoice->penjualans;
	
	$hargaTotal = 0;
?>
<div class="print-section">

	<h1>Invoice Penjualan #<?php echo $invoice->nomor; ?></h1>
	<hr>
	
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
		<?php endforeach;?>
	</table>
	
	<div class="row">
		<div class="col-xs-7">
			<h4>Komentar</h4>
			<?php echo $invoice->comment_external; ?>
		</div>
		<div class="col-xs-3">
			<h5>Harga Total</h5>
			<h5>Biaya Pengiriman</h5>
			<h5><b>Total</b></h5><br>
			<h5>Pembayaran</h5>
			<h5><b>Down Payment</b></h5>
		</div>
		<div class="col-xs-2">
			<h5><?php echo Utilities::currency($hargaTotal); ?></h5>
			<h5><?php echo Utilities::currency($invoice->biaya_pengiriman); ?></h5>
			<h5><b><?php echo Utilities::currency($hargaTotal + $invoice->biaya_pengiriman); ?></b></h5><br>
			<h5 class="tes"><?php echo $invoice->jenis_pembayaran?></h5>
			<h5><b><?php echo Utilities::currency($invoice->down_payment); ?></b></h5>
		</div>
	</div>

	<script type="text/javascript">
		if('matchMedia' in window) {
			window.matchMedia('print').addListener(function(media) {
				window.onfocus=function() {
					window.location.replace("<?php echo Yii::app()->createUrl('invoicePenjualan/createNew'); ?>");
				};
			});
		}
		
		$(document).ready(function() {
			window.print();
		});

		window.onafterprint = function() {
			window.location.replace("<?php echo Yii::app()->createUrl('invoicePenjualan/createNew'); ?>");
		}
	</script>
</div>
