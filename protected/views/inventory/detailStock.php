<?php
	/* @var $this InventoryController */
	/* @var $name string */
	/* @var $locationInfo string=>int */
	/* @var $reportInfo Entri[] */
?>

<h1><?php echo $name; ?></h1>
<hr>

<h3>Posisi Barang</h3>
<?php foreach($locationInfo as $name=>$count): ?>
	<div class="row">
		<div class="col-md-3"><h5><?php echo $name; ?></h5></div>
		<div class="col-md-3"><h5>: <?php echo $count;?></h5></div>
	</div>
<?php endforeach; ?>

<hr>

<table class="table">
	<tr>
		<th>Tanggal</th>
		<th>Debet</th>
		<th>Kredit</th>
		<th>Balance</th>
	</tr>
	<?php foreach ($reportInfo as $entri): ?>
		<tr>
			<td><?php echo $entri->getDate(); ?></td>
			<td><?php echo $entri->getDebet(); ?></td>
			<td><?php echo $entri->getKredit(); ?></td>
			<td><?php echo $entri->getSaldo(); ?></td>
		</tr>
	<?php endforeach; ?>
</table>