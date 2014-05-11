<?php
/* @var $this InvoicePembelianController */
/* @var $model InvoicePembelian */

Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.datetimepicker.js');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/jquery.datetimepicker.css');

?>

<h1>Invoice Pembelian</h1>
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


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'invoice-pembelian-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nama_supplier'); ?>
		<?php echo $form->textField($model,'nama_supplier',array('size'=>60,'maxlength'=>127, 'class'=>'form-control')); ?>
		<?php echo $form->error($model,'nama_supplier'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'jatuh_tempo_pembayaran'); ?>
		<?php echo $form->textField($model,'jatuh_tempo_pembayaran',array('class'=>'dateTimePicker form-control')); ?>
		<?php echo $form->error($model,'jatuh_tempo_pembayaran'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'biaya_pengiriman'); ?>
		<?php echo $form->textField($model,'biaya_pengiriman',array('size'=>20,'maxlength'=>10, 'class'=>'form-control')); ?>
		<?php echo $form->error($model,'biaya_pengiriman'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'comment_internal'); ?>
		<?php echo $form->textArea($model,'comment_internal',array('class'=>'form-control', 'rows'=>4)); ?>
		<?php echo $form->error($model,'comment_internal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment_external'); ?>
		<?php echo $form->textArea($model,'comment_external',array('class'=>'form-control', 'rows'=>4)); ?>
		<?php echo $form->error($model,'comment_external'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::tag('button', array('class'=>'btn btn-primary pull-right'), 'Next<span class="glyphicon glyphicon-chevron-right"></span>'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	$('.dateTimePicker').datetimepicker({
	  format:'d-m-Y H:i',
	  mask:true,
	  lang:'en'
	});
</script>