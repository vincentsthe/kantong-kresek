<?php
/* @var $this InventoryController */
/* @var $model Inventory */
?>

<h1>Register <?php echo $model->nama_barang; ?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'inventory-form',
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
		<?php echo $form->labelEx($model,'harga_minimum'); ?>
		<?php echo $form->textField($model,'harga_minimum', array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'harga_minimum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'harga_minimum_khusus'); ?>
		<?php echo $form->textField($model,'harga_minimum_khusus', array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'harga_minimum_khusus'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Simpan', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div>