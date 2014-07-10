<?php
/* @var $this AccountingController */
/* @var $model Accounting */

$this->breadcrumbs=array(
	'Accountings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Accounting', 'url'=>array('index')),
	array('label'=>'Create Accounting', 'url'=>array('create')),
	array('label'=>'Update Accounting', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Accounting', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Accounting', 'url'=>array('admin')),
);
?>

<h1>View Accounting #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'kode',
		'pesan',
		'transaksi',
	),
)); ?>
