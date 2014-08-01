<?php
	/* @var $this InventoryController */
	/* @var $listStock Stok[] */
	/* @var $listCabang Cabang[] */
	/* @var $pageCount int */
	/* @var $currentPage int */
	
	function createLink($newPage) {
		$return = array('inventory/listStok');
		if(isset($_GET['lokasi'])) {
			$return['lokasi'] = $_GET['lokasi'];
		}
		if(isset($_GET['filter'])) {
			$return['filter'] = $_GET['filter'];
		}
		$return['page'] = $newPage;
		return $return;
	}
	Yii::import('ext.Utilities');
?>

<h1>Stok</h1>
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
		<h4 class="pull-left">Daftar Stok Barang</h4>
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
	<div class="panel-body">
		<table class="table">
			<?php foreach ($listStock as $stock): ?>
				<tr>
					<td><?php echo $stock->getNama(); ?></td>
					<td><?php echo $stock->getJumlah(); ?></td>
					<td><?php echo CHtml::link('<span class="glyphicon glyphicon-search"></span>', array('inventory/detailStock', 'name'=>$stock->getNama())); ?></td>
				</tr>
			<?php endforeach;?>
		</table>
	</div>
	
</div>

<ul class="pagination">
	<li><?php echo CHtml::link("&laquo", createLink(0))?></li>
	<?php for($i=max($currentPage-5, 0) ; $i<$currentPage ; $i++): ?>
		<li><?php echo CHtml::link($i+1, createLink($i))?></li>
	<?php endfor;?>
	<li class="active"><a href=""><?php echo $currentPage+1; ?></a></li>
	<?php for($i=$currentPage+1 ; $i<min($currentPage+5, $pageCount) ; $i++): ?>
		<li><?php echo CHtml::link($i+1, createLink($i))?></li>
	<?php endfor; ?>
	<li><?php echo CHtml::link("&raquo", createLink($pageCount-1))?></li>
</ul>