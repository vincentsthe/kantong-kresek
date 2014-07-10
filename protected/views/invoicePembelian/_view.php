<?php
/* @var $this InvoicePembelianController */
/* @var $data InvoicePembelian */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nomor')); ?>:</b>
	<?php echo CHtml::encode($data->nomor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nama_supplier')); ?>:</b>
	<?php echo CHtml::encode($data->nama_supplier); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('waktu_penerbitan')); ?>:</b>
	<?php echo CHtml::encode($data->waktu_penerbitan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jatuh_tempo_pembayaran')); ?>:</b>
	<?php echo CHtml::encode($data->jatuh_tempo_pembayaran); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_internal')); ?>:</b>
	<?php echo CHtml::encode($data->comment_internal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_external')); ?>:</b>
	<?php echo CHtml::encode($data->comment_external); ?>
	<br />


</div>