<?php
/* @var $this InvoicePembelianController */
/* @var $contact PenjualanContactForm */
/* @var $listPenjualan Penjualan[] */

Yii::import('ext.Utilities');
$hargaTotal = 0;
$diskonTotal = 0;
?>

<h1>Pembayaran</h1>
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
	<div class="col-md-6">
		<h4><b>Pembeli:</b></h4>
		<h5><?php echo $contact->nama_pembeli; ?></h5>
		<h5><?php echo $contact->alamat_pembeli; ?></h5>
		<h5><?php echo $contact->telpon_pembeli; ?></h5>
	</div>
	<div class="col-md-6">
		<h4><b>Dikirim:</b></h4>
		<h5><?php echo $contact->nama_terkirim; ?></h5>
		<h5><?php echo $contact->alamat_terkirim; ?></h5>
		<h5><?php echo $contact->telpon_terkirim; ?></h5>
	</div>
</div>

<h2>Daftar Barang</h2>

<table class="table table-striped table-bordered">
	<tr>
		<th>Nama Barang</th>
		<th>Quantity</th>
		<th>Harga</th>
		<th>Total</th>
	</tr>
	<?php foreach($listPenjualan as $item): ?>
		<tr>
			<td><?php echo $item->nama_barang?></td>
			<td><?php echo $item->quantity?></td>
			<td class="text-right"><?php echo Utilities::currency($item->harga); ?></td>
			<td class="text-right"><?php echo Utilities::currency($item->harga * $item->quantity); ?></td>
		</tr>
		<?php $hargaTotal += $item->harga * $item->quantity?>
		<?php $diskonTotal += ($item->harga - $item->harga_terjual) * $item->quantity?>
	<?php endforeach;?>
</table>

<div class="row">
	<div class="col-md-7"></div>
	<div class="col-md-3">
		<h5>Jumlah</h5>
		<h5>Diskon</h5>
		<h5><b>Total</b></h5>
	</div>
	<div class="col-md-2">
		<h5><?php echo Utilities::currency($hargaTotal); ?></h5>
		<h5><?php echo Utilities::currency($diskonTotal); ?></h5>
		<h5><b><?php echo Utilities::currency($hargaTotal - $diskonTotal); ?></b></h5>
	</div>
</div>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pembayaranPenjualan-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo $form->errorSummary($pembayaranForm); ?>

	<div class="row">
		<?php echo $form->labelEx($pembayaranForm,'biaya_pengiriman'); ?>
		<?php echo $form->textField($pembayaranForm,'biaya_pengiriman', array('class'=>'form-control')); ?>
		<?php echo $form->error($pembayaranForm,'biaya_pengiriman'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($pembayaranForm,'down_payment'); ?>
		<?php echo $form->textField($pembayaranForm,'down_payment', array('class'=>'form-control')); ?>
		<?php echo $form->error($pembayaranForm,'down_payment'); ?>
	</div>
	
	<div class="col-md-4">
		<?php echo $form->labelEx($pembayaranForm,'jenis_pembayaran'); ?>
		<?php echo $form->dropDownList($pembayaranForm, 'jenis_pembayaran', array('Tunai'=>'Tunai', 'Transfer'=>'Transfer', 'Cek'=>'Cek', 'Kredit'=>'Kredit'), array('class'=>'form-control')); ?>
	</div>
	<br><br><br><br>
	
	<div class="row">
		<?php echo $form->labelEx($pembayaranForm,'comment_external'); ?>
		<?php echo $form->textArea($pembayaranForm,'comment_external', array('class'=>'form-control', 'rows'=>5)); ?>
		<?php echo $form->error($pembayaranForm,'comment_external'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($pembayaranForm,'comment_internal'); ?>
		<?php echo $form->textArea($pembayaranForm,'comment_internal', array('class'=>'form-control', 'rows'=>5)); ?>
		<?php echo $form->error($pembayaranForm,'comment_internal'); ?>
	</div>

	<div class="row buttons text-center">
		<?php echo CHtml::submitButton('Lanjut', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div>

<?php echo CHtml::link('<span class="glyphicon glyphicon-chevron-left"></span>Sebelumnya', array('invoicePenjualan/preview'), array('class'=>'btn btn-warning pull-left')); ?>

<br><br><br>


