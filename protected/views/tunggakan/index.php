<?php
/* @var $this TunggakanController */
/* @var $dataProvider CActiveDataProvider */

Yii::import('ext.Utilities');
?>

<h1>Tunggakan</h1>
<hr>
<?php if(Yii::app()->user->hasFlash('error')): ?>
	<div class="alert alert-danger">
		<?php echo Yii::app()->user->getFlash('error'); ?>
	</div>
<?php endif;?>

<?php if(Yii::app()->user->hasFlash('success')): ?>
	<div class="alert alert-success">
		<?php echo Yii::app()->user->getFlash('success'); ?>
	</div>
<?php endif;?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Daftar Tunggakan</h4>
		<form name="form1" class="form form-inline pull-right p-r-10" action="?" method="GET">
			<div class="input-group" style="width: 300px">
				<input type="text" class="form-control" name="filter" value="<?php if(isset($_GET['filter'])) echo $_GET['filter']; ?>">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" onclick="document.form1.submit()"><span class="glyphicon glyphicon-search"></span></button>
				</span>
			</div>
		</form>
		<div class="clearfix"></div>
	</div>
	<?php $gridView = $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'template'=>"{items}",
		'columns' => array (
			'id',
			array(
				'name'=> 'Invoice',
				'type'=>'raw',
				'value'=> 'CHtml::link($data->invoice->nomor, array("invoicePenjualan/view", "id"=>$data->invoice_id))',
			),
			'nama',
			array(
				'name'=> 'Besar Tunggakan',
				'value'=> 'Utilities::currency($data->jumlah)',
			),
			array(
				'name'=>'',
				'type'=>'raw',
				'value'=>function($data) {
					return 	CHtml::link('<span class="glyphicon glyphicon-edit"></span>', array('tunggakan/bayar', 'id'=>$data->id));
				},
			),
		),
		'itemsCssClass' => 'table table-striped',
		'pager' => array (
			'header'=>'',
			'internalPageCssClass'=>'sds',
			'htmlOptions' => array (
				'class'=>'pagination',
			)
		)
	)); ?>
</div>

<?php $gridView->renderPager(); ?>