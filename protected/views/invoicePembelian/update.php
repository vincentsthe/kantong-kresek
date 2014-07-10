<?php
/* @var $this InvoicePembelianController */
/* @var $model InvoicePembelian */

$this->breadcrumbs=array(
	'Invoice Pembelians'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List InvoicePembelian', 'url'=>array('index')),
	array('label'=>'Create InvoicePembelian', 'url'=>array('create')),
	array('label'=>'View InvoicePembelian', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage InvoicePembelian', 'url'=>array('admin')),
);
?>

<h1>Update InvoicePembelian <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>