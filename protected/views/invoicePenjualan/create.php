<?php
/* @var $this InvoicePenjualanController */
/* @var $model PenjualanContactForm */


?>

<h1>Terbitkan InvoicePenjualan</h1>
<hr>
<div class="font-light">*Diterbitkan dari cabang <?php echo Cabang::model()->findByPk(Yii::app()->user->location)->nama; ?>.</div>
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
	'id'=>'invoice-penjualan-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<div class="col-md-6">
			<div class="row">
				<?php echo $form->labelEx($model,'nama_pembeli'); ?>
				<?php echo $form->textField($model,'nama_pembeli',array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'nama_pembeli'); ?>
			</div>
		
			<div class="row">
				<?php echo $form->labelEx($model,'alamat_pembeli'); ?>
				<?php echo $form->textArea($model,'alamat_pembeli',array('class'=>'form-control', 'rows'=>4)); ?>
				<?php echo $form->error($model,'alamat_pembeli'); ?>
			</div>
		
			<div class="row">
				<?php echo $form->labelEx($model,'telpon_pembeli'); ?>
				<?php echo $form->textField($model,'telpon_pembeli',array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'telpon_pembeli'); ?>
			</div>
		</div>
	
		<div class="col-md-6">
			<div class="row">
				<?php echo $form->labelEx($model,'nama_terkirim'); ?>
				<?php echo $form->textField($model,'nama_terkirim',array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'nama_terkirim'); ?>
			</div>
		
			<div class="row">
				<?php echo $form->labelEx($model,'alamat_terkirim'); ?>
				<?php echo $form->textArea($model,'alamat_terkirim',array('class'=>'form-control', 'rows'=>4)); ?>
				<?php echo $form->error($model,'alamat_terkirim'); ?>
			</div>
		
			<div class="row">
				<?php echo $form->labelEx($model,'telpon_terkirim'); ?>
				<?php echo $form->textField($model,'telpon_terkirim',array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'telpon_terkirim'); ?>
			</div>
		</div>
	</div>
	
	<br><br>
	<div class="row buttons">
		<?php echo CHtml::tag('button', array('class'=>'btn btn-primary pull-right'), 'Next<span class="glyphicon glyphicon-chevron-right"></span>'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->