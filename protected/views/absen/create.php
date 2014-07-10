<?php
/* @var $this AbsenController */
/* @var $model Absen */

$this->breadcrumbs=array(
	'Absens'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Absen', 'url'=>array('index')),
	array('label'=>'Manage Absen', 'url'=>array('admin')),
);
?>

<h1>Create Absen</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>