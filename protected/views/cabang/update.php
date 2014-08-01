<?php
/* @var $this CabangController */
/* @var $model Cabang */

$this->breadcrumbs=array(
	'Cabangs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Cabang', 'url'=>array('index')),
	array('label'=>'Create Cabang', 'url'=>array('create')),
	array('label'=>'View Cabang', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Cabang', 'url'=>array('admin')),
);
?>

<h1>Update Cabang <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>