<?php
	// @var $barang		Inventory
	// @var $hargaForm	AddPenjualanForm
	
	Yii::import('ext.Utilities');
?>

<h1>Tambah Barang</h1>
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
		<h5 class="font-light">Nama Barang</h5>
	</div>
	<div class="col-md-9">
		<h5 class="font-light"><?php echo $barang->nama_barang; ?></h5>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<h5 class="font-light">Harga Minimum</h5>
	</div>
	<div class="col-md-9">
		<h5 class="font-light"><?php 
			echo Utilities::currency($barang->harga_minimum);
		?></h5>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<h5 class="font-light">Harga Minimum Khusus</h5>
	</div>
	<div class="col-md-9">
		<h5 class="font-light"><?php 
			echo Utilities::currency($barang->harga_minimum_khusus);
		?></h5>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<h5 class="font-light">Jumlah Barang Tersedia</h5>
	</div>
	<div class="col-md-9">
		<h5 class="font-light"><?php echo $barang->jumlah_barang; ?></h5>
	</div>
</div>
<hr>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'addPenjualan-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo $form->errorSummary($hargaForm); ?>

	<div class="row">
		<?php echo $form->labelEx($hargaForm,'jumlah'); ?>
		<?php echo $form->textField($hargaForm,'jumlah', array('class'=>'form-control')); ?>
		<?php echo $form->error($hargaForm,'jumlah'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($hargaForm,'harga'); ?>
		<?php echo $form->textField($hargaForm,'harga', array('class'=>'form-control')); ?>
		<?php echo $form->error($hargaForm,'harga'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Tambah', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

<br><br>
<?php echo CHtml::link('<span class="glyphicon glyphicon-chevron-left"></span>Kembali', array('invoicePenjualan/preview'), array('class'=>'btn btn-warning pull-left')); ?>
<br><br><br><br>

</div>