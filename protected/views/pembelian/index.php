<?php
/* @var $this PembelianController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Pembelians',
);

$this->menu=array(
	array('label'=>'Create Pembelian', 'url'=>array('create')),
	array('label'=>'Manage Pembelian', 'url'=>array('admin')),
);
?>

<h1>Pembelians</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
