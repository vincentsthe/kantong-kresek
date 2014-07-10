<?php
/* @var $this TunggakanController */
/* @var $model Tunggakan */

$this->breadcrumbs=array(
	'Tunggakans'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Tunggakan', 'url'=>array('index')),
	array('label'=>'Create Tunggakan', 'url'=>array('create')),
	array('label'=>'Update Tunggakan', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Tunggakan', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Tunggakan', 'url'=>array('admin')),
);
?>

<h1>View Tunggakan #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'jumlah',
		'invoice_id',
	),
)); ?>
