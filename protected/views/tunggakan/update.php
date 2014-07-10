<?php
/* @var $this TunggakanController */
/* @var $model Tunggakan */

$this->breadcrumbs=array(
	'Tunggakans'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Tunggakan', 'url'=>array('index')),
	array('label'=>'Create Tunggakan', 'url'=>array('create')),
	array('label'=>'View Tunggakan', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Tunggakan', 'url'=>array('admin')),
);
?>

<h1>Update Tunggakan <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>