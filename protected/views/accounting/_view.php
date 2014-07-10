<?php
/* @var $this AccountingController */
/* @var $data Accounting */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kode')); ?>:</b>
	<?php echo CHtml::encode($data->kode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pesan')); ?>:</b>
	<?php echo CHtml::encode($data->pesan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transaksi')); ?>:</b>
	<?php echo CHtml::encode($data->transaksi); ?>
	<br />


</div>