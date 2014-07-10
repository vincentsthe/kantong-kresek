<?php
/* @var $this InventoryController */
/* @var $barang Inventory */
/* @var $model AssignItemForm */
?>

<h1>Register <?php echo $barang->nama_barang; ?></h1>
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

<div class="font-light">Terdapat <?php echo $barang->jumlah_barang?> barang.</div>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'assign-item-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'lokasi'); ?>
		<?php echo $form->dropDownList($model,'lokasi', Cabang::findAllLocation(), array('class'=>'form-control', 'empty'=>'Pilih Cabang')); ?>
		<?php echo $form->error($model,'lokasi'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'harga'); ?>
		<?php echo $form->textField($model,'harga', array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'harga'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'harga_minimum'); ?>
		<?php echo $form->textField($model,'harga_minimum', array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'harga_minimum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'harga_minimum_khusus'); ?>
		<?php echo $form->textField($model,'harga_minimum_khusus', array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'harga_minimum_khusus'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'jumlah'); ?>
		<?php echo $form->textField($model,'jumlah', array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'jumlah'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'serial_number'); ?>
		<?php echo $form->textField($model,'serial_number', array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'serial_number'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Simpan', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div>