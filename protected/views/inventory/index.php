<?php
/* @var $this InventoryController */
/* @var $dataProvider CActiveDataProvider */
/* @var $listCabang Cabang[]*/

Yii::import('ext.Utilities');
?>

<h1>Inventarisasi</h1>
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

<div class="row">
	<div class="col-md-2">
		<h4>Pilih Cabang</h4>
	</div>
	<div class="col-md-10">
		<div class="btn-group">
			<button type="button" class="btn btn-info">
				<?php 
					if(!isset($_GET['lokasi'])) {
						echo "Semua Cabang";
					} else {
						echo $listCabang[$_GET['lokasi']-1]->nama;
					}				
				?>
			</button>
			<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
				<span class="caret"></span>
				<span class="sr-only">Toggle Dropdown</span>
			</button>
			<ul class="dropdown-menu" roles="menu">
				<li><a href="?">Semua Cabang</a></li>
				<?php foreach($listCabang as $cabang): ?>
					<li><a href="?lokasi=<?php echo $cabang->id;?>"><?php echo $cabang->nama;?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
<br><br>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Daftar Inventarisasi</h4>
		<form name="form1" class="form form-inline pull-right p-r-10" action="?" method="GET">
			<div class="input-group" style="width: 300px">
				<input type="text" class="form-control" name="filter" value="<?php if(isset($_GET['filter'])) echo $_GET['filter']; ?>">
				<?php if(isset($_GET['lokasi'])): ?>
					<input type="hidden" name="lokasi" value="<?php echo $_GET['lokasi']; ?>">
				<?php endif;?>
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
			'nama_barang',
			'jumlah_barang',
			array(
				'name'=>'Invoice',
				'value'=>'$data->invoice->nomor',
			),
			array(
				'name'=>'Lokasi',
				'value'=>'$data->lokasi0->nama',
			),
			array(
				'name'=>'Harga Minimum',
				'value'=>'Utilities::currency($data->harga_minimum)',
			),
			array(
				'name'=>'Harga Minimum Khusus',
				'value'=>'Utilities::currency($data->harga_minimum_khusus)',
			),
			array(
				'name'=>'',
				'type'=>'raw',
				'value'=>function($data) {
					return CHtml::link('<span class="glyphicon glyphicon-edit"></span>', array('inventory/updateHarga', 'id'=>$data->id));
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