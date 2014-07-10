<?php
/* @var $this InventoryController */
/* @var $form PembayaranForm */
/* @var $tunggakan Tunggakan */

Yii::import('ext.Utilities');
?>

<h1>Pembayaran Tunggakan</h1>
<hr>

<div class="row">
	<div class="col-md-3">
		<h5 class="font-light">Nama</h5>
	</div>
	<div class="col-md-9">
		<h5><?php 
			echo $tunggakan->nama;
		?></h5>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<h5 class="font-light">Invoice</h5>
	</div>
	<div class="col-md-9">
		<h5><?php 
			echo CHtml::link($tunggakan->invoice->nomor, array("invoicePenjualan/view", "id"=>$tunggakan->invoice_id));
		?></h5>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<h5 class="font-light">Jumlah Awal</h5>
	</div>
	<div class="col-md-9">
		<h5><?php 
			echo Utilities::currency($tunggakan->jumlah);
		?></h5>
	</div>
</div>

<div class="form">

<?php $form1=$this->beginWidget('CActiveForm', array(
	'id'=>'bayar-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form1->errorSummary($form); ?>
	
	<div class="row">
		<?php echo $form1->labelEx($form,'jumlah'); ?>
		<?php echo $form1->textField($form,'jumlah', array('class'=>'form-control')); ?>
		<?php echo $form1->error($form,'jumlah'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Bayar', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div>