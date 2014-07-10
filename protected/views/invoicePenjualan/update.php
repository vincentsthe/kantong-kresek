<?php
/* @var $this InvoicePenjualanController */
/* @var $model InvoicePenjualan */

$this->breadcrumbs=array(
	'Invoice Penjualans'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List InvoicePenjualan', 'url'=>array('index')),
	array('label'=>'Create InvoicePenjualan', 'url'=>array('create')),
	array('label'=>'View InvoicePenjualan', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage InvoicePenjualan', 'url'=>array('admin')),
);
?>

<h1>Update InvoicePenjualan <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>