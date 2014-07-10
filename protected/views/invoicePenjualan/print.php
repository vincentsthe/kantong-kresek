<?php
	/* @var $this InvoicePenjualanController */
	/* @var $invoice InvoicePenjualan */

	Yii::import('ext.Utilities');
	$listPenjualan = $invoice->penjualans;
	
	$hargaTotal = 0;
	$diskonTotal = 0;
?>
<div class="print-section">

	<span class="minimal-padding title" style="margin:5px;">Kantong Kresek</span>
	<span class="minimal-padding" style="margin:5px;font-size:0.8em;">Mangga Dua Mall Lantai 5 Blok C117</span>
	<div class="minimal-padding" style="margin:5px;">#<?php echo $invoice->nomor; ?></div>
	<hr>
	
	<table style="width:100%">
		<tr>
			<td width="50%" style="" valign="top">
				<div class="subtitle">Pembeli:</div>
				<div class="inside-table"><?php echo $invoice->nama_pembeli; ?></div>
				<div class="inside-table"><?php echo $invoice->alamat_pembeli; ?></div>
				<div class="inside-table"><?php echo $invoice->telpon_pembeli; ?></div>
			</td>
			<td width="50%" style="" valign="top">
				<div class="subtitle">Dikirim:</div>
				<div class="inside-table"><?php echo $invoice->nama_terkirim; ?></div>
				<div class="inside-table"><?php echo $invoice->alamat_terkirim; ?></div>
				<div class="inside-table"><?php echo $invoice->telpon_terkirim; ?></div>
			</td>
		</tr>
	</table>
	
	<br>
	<div class="subtitle">Daftar Barang</div>
	
	<table class="table">
		<tr>
			<th>Nama</th>
			<th>Jumlah</th>
			<th>Harga</th>
			<th>Total</th>
			<th>S/N</th>
		</tr>
		<?php foreach($listPenjualan as $item): ?>
			<tr>
				<td><?php echo $item->nama_barang?></td>
				<td><?php echo $item->quantity?></td>
				<td class="text-right"><?php echo Utilities::currency($item->harga); ?></td>
				<td class="text-right"><?php echo Utilities::currency($item->harga * $item->quantity); ?></td>
				<td><?php echo $item->serial_number; ?></td>
			</tr>
			<?php $hargaTotal += $item->harga * $item->quantity?>
			<?php $diskonTotal += ($item->harga - $item->harga_terjual) * $item->quantity?>
		<?php endforeach;?>
	</table>
	
	<br>
	<table style="width:100%;">
		<tr>
			<td style="width:65%;" valign="top">
				<div class="subtitle">Komentar</div>
				<?php echo $invoice->comment_external; ?>
			</td>
			<td style="width:15%;" valign="top">
				<div>Harga Total</div>
				<div>Pengiriman</div>
				<div>Jumlah</div>
				<div>Diskon</div>
				<div><b>Total</b></div><br>
				<div>Pembayaran</div>
				<div><b>Down Payment</b></div>
			</td>
			<td style="width:20%;" valign="top">
				<div><?php echo Utilities::currency($hargaTotal); ?></div>
				<div><?php echo Utilities::currency($invoice->biaya_pengiriman); ?></div>
				<div><?php echo Utilities::currency($hargaTotal); ?></div>
				<div><?php echo Utilities::currency($diskonTotal); ?></div>
				<div><b><?php echo Utilities::currency($hargaTotal - $diskonTotal); ?></b></div><br>
				<div><?php echo $invoice->jenis_pembayaran?></div>
				<div><b><?php echo Utilities::currency($invoice->down_payment); ?></b></div>
			</td>
		</tr>
	</table>

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
