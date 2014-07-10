<?php
/* @var $this AccountingController */
/* @var $model Accounting */
?>

<h1>Buat Data Administrasi Baru</h1>
<hr>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'accounting-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php $listCode = KodeAccounting::findAllCode(); ?>
	
		<?php echo $form->labelEx($model,'kode'); ?>
		<?php echo $form->dropDownList($model,'kode', $listCode, array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'kode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pesan'); ?>
		<?php echo $form->textField($model,'pesan', array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'pesan'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transaksi'); ?>
		<?php echo $form->textField($model,'transaksi', array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'transaksi'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>