<?php
/* @var $this InvoicePenjualanController */
/* @var $model InvoicePenjualan */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'invoice-penjualan-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nomor'); ?>
		<?php echo $form->textField($model,'nomor',array('size'=>60,'maxlength'=>127)); ?>
		<?php echo $form->error($model,'nomor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nama_pembeli'); ?>
		<?php echo $form->textField($model,'nama_pembeli',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'nama_pembeli'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alamat_pembeli'); ?>
		<?php echo $form->textField($model,'alamat_pembeli',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'alamat_pembeli'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'telpon_pembeli'); ?>
		<?php echo $form->textField($model,'telpon_pembeli',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'telpon_pembeli'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nama_terkirim'); ?>
		<?php echo $form->textField($model,'nama_terkirim',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'nama_terkirim'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alamat_terkirim'); ?>
		<?php echo $form->textField($model,'alamat_terkirim',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'alamat_terkirim'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'telpon_terkirim'); ?>
		<?php echo $form->textField($model,'telpon_terkirim',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'telpon_terkirim'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment_internal'); ?>
		<?php echo $form->textField($model,'comment_internal',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'comment_internal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment_external'); ?>
		<?php echo $form->textField($model,'comment_external',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'comment_external'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'waktu_penerbitan'); ?>
		<?php echo $form->textField($model,'waktu_penerbitan',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'waktu_penerbitan'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'jenis_pembayaran'); ?>
		<?php echo $form->textField($model,'jenis_pembayaran',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'jenis_pembayaran'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'down_payment'); ?>
		<?php echo $form->textField($model,'down_payment'); ?>
		<?php echo $form->error($model,'down_payment'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->