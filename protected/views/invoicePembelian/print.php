<?php
/* @var $this InvoicePembelianController */
/* @var $model InvoicePembelian */

Yii::import('ext.utilities');
$listItem = $model->pembelians;

$hargaTotal = 0;
?>

<div class="print-section">
	<h1>InvoicePembelian #<?php echo $model->nomor; ?></h1>
	<hr>
	
	
	<div class="row">
		<div class="col-md-3">
			<h5 class="font-light">Supplier</h5>
		</div>
		<div class="col-md-9">
			<h5><?php echo $model->nama_supplier?></h5>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-3">
			<h5 class="font-light">Biaya Pengiriman</h5>
		</div>
		<div class="col-md-9">
			<h5><?php 
				echo Utilities::currency($model->biaya_pengiriman);
			?></h5>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-3">
			<h5 class="font-light">Jatuh Tempo Pembayaran</h5>
		</div>
		<div class="col-md-9">
			<h5><?php echo Utilities::timestampToFormattedDate($model->jatuh_tempo_pembayaran); ?></h5>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-3">
			<h5 class="font-light">Waktu Penerbitan</h5>
		</div>
		<div class="col-md-9">
			<h5><?php echo Utilities::timestampToFormattedDate($model->waktu_penerbitan); ?></h5>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12 font-light">
			<h4>Comment Internal</h4>
		</div>
		<div class="col-md-12">
			<?php 
				if(strlen($model->comment_internal) != 0) {
					echo $model->comment_internal;
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
				if(strlen($model->comment_external) != 0) {
					echo $model->comment_external;
				} else {
					echo "&nbsp&nbsp&nbsp-";
				}
			?>
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
		<?php foreach($listItem as $item): ?>
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
		<div class="col-md-7"></div>
		<div class="col-md-3">
			<h5>Total Harga</h5>
			<h5>Biaya Pengiriman</h5>
			<h5><b>Total</b></h5>
		</div>
		<div class="col-md-2">
			<h5><?php echo Utilities::currency($hargaTotal); ?></h5>
			<h5><?php echo Utilities::currency($model->biaya_pengiriman); ?></h5>
			<h5><b><?php echo Utilities::currency($hargaTotal + $model->biaya_pengiriman); ?></b></h5><br>
		</div>
	</div>
	
	<script type="text/javascript">
		if('matchMedia' in window) {
			window.matchMedia('print').addListener(function(media) {
				window.onfocus=function() {
					window.close();
				};
			});
		}
		
		$(document).ready(function() {
			window.print();
		});

		window.onafterprint = function() {
			window.close();
		}
	</script>
</div>