<?php
/* @var $this PembelianController */
/* @var $model Pembelian */

$this->breadcrumbs=array(
	'Pembelians'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Pembelian', 'url'=>array('index')),
	array('label'=>'Create Pembelian', 'url'=>array('create')),
	array('label'=>'Update Pembelian', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Pembelian', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pembelian', 'url'=>array('admin')),
);
?>

<h1>View Pembelian #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nama_barang',
		'quantity',
		'harga',
		'invoice_id',
	),
)); ?>
