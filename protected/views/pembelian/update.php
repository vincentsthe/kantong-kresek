<?php
/* @var $this PembelianController */
/* @var $model Pembelian */

$this->breadcrumbs=array(
	'Pembelians'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Pembelian', 'url'=>array('index')),
	array('label'=>'Create Pembelian', 'url'=>array('create')),
	array('label'=>'View Pembelian', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Pembelian', 'url'=>array('admin')),
);
?>

<h1>Update Pembelian <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>