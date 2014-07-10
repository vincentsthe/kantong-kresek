<?php
/* @var $this AccountingController */
/* @var $model Accounting */

$this->breadcrumbs=array(
	'Accountings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Accounting', 'url'=>array('index')),
	array('label'=>'Create Accounting', 'url'=>array('create')),
	array('label'=>'View Accounting', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Accounting', 'url'=>array('admin')),
);
?>

<h1>Update Accounting <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>