<?php
/* @var $this TunggakanController */
/* @var $model Tunggakan */

$this->breadcrumbs=array(
	'Tunggakans'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Tunggakan', 'url'=>array('index')),
	array('label'=>'Manage Tunggakan', 'url'=>array('admin')),
);
?>

<h1>Create Tunggakan</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>