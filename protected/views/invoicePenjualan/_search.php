<?php
/* @var $this InvoicePenjualanController */
/* @var $model InvoicePenjualan */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nomor'); ?>
		<?php echo $form->textField($model,'nomor',array('size'=>60,'maxlength'=>127)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nama_pembeli'); ?>
		<?php echo $form->textField($model,'nama_pembeli',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'alamat_pembeli'); ?>
		<?php echo $form->textField($model,'alamat_pembeli',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'telpon_pembeli'); ?>
		<?php echo $form->textField($model,'telpon_pembeli',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nama_terkirim'); ?>
		<?php echo $form->textField($model,'nama_terkirim',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'alamat_terkirim'); ?>
		<?php echo $form->textField($model,'alamat_terkirim',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'telpon_terkirim'); ?>
		<?php echo $form->textField($model,'telpon_terkirim',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comment_internal'); ?>
		<?php echo $form->textField($model,'comment_internal',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comment_external'); ?>
		<?php echo $form->textField($model,'comment_external',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'waktu_penerbitan'); ?>
		<?php echo $form->textField($model,'waktu_penerbitan',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'jenis_pembayaran'); ?>
		<?php echo $form->textField($model,'jenis_pembayaran',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'down_payment'); ?>
		<?php echo $form->textField($model,'down_payment'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->