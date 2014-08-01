<?php
/* @var $this UserController */
/* @var $loginPermission Map<CabangName, User[]> */
?>

<h1>Buat Izin Baru</h1>
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
	'id'=>'login-permission-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cabang'); ?>
		<?php echo $form->dropDownList($model,'cabang', Cabang::findAllLocation(), array('class'=>'form-control', 'empty'=>'Pilih Cabang')); ?>
		<?php echo $form->error($model,'cabang'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'user'); ?>
		<?php echo $form->dropDownList($model,'user', User::findAllUser(), array('class'=>'form-control', 'empty'=>'Pilih User')); ?>
		<?php echo $form->error($model,'user'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Buat', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div>