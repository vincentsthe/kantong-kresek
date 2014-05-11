<?php
/* @var $this InvoicePenjualanController */
/* @var $data InvoicePenjualan */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nomor')); ?>:</b>
	<?php echo CHtml::encode($data->nomor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nama_pembeli')); ?>:</b>
	<?php echo CHtml::encode($data->nama_pembeli); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alamat_pembeli')); ?>:</b>
	<?php echo CHtml::encode($data->alamat_pembeli); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telpon_pembeli')); ?>:</b>
	<?php echo CHtml::encode($data->telpon_pembeli); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nama_terkirim')); ?>:</b>
	<?php echo CHtml::encode($data->nama_terkirim); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alamat_terkirim')); ?>:</b>
	<?php echo CHtml::encode($data->alamat_terkirim); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('telpon_terkirim')); ?>:</b>
	<?php echo CHtml::encode($data->telpon_terkirim); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_internal')); ?>:</b>
	<?php echo CHtml::encode($data->comment_internal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_external')); ?>:</b>
	<?php echo CHtml::encode($data->comment_external); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('waktu_penerbitan')); ?>:</b>
	<?php echo CHtml::encode($data->waktu_penerbitan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenis_pembayaran')); ?>:</b>
	<?php echo CHtml::encode($data->jenis_pembayaran); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('down_payment')); ?>:</b>
	<?php echo CHtml::encode($data->down_payment); ?>
	<br />

	*/ ?>

</div>